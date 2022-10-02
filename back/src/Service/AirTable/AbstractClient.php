<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\BlockInterface;
use Symfony\Component\HttpClient\Exception\ClientException;

abstract class AbstractClient
{
    private const NB_TRY_RANDOM = 5;

    private array $recordsByParam = [];
    private array $randomKeyByParam = [];

    public function __construct(private readonly AirtableClient $airtableClient, private readonly string $airtableAppId, private readonly BuilderInterface $builder)
    {
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        $keyResearch = $this->createKey($param);

        if (!isset($this->recordsByParam[$keyResearch])) {
            $this->recordsByParam[$keyResearch] = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl()),
                    $param,
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            )['records'];
        }

        $articles = $this->recordsByParam[$keyResearch];
        if ((is_countable($articles) ? count($articles) : 0) === 0) {
            return null;
        }

        $key = array_rand($articles);

        if (!isset($this->randomKeyByParam[$keyResearch])) {
            $this->randomKeyByParam[$keyResearch] = [];
        }

        $count = 0;
        while ($count < self::NB_TRY_RANDOM && in_array($key, $this->randomKeyByParam[$keyResearch], true)) {
            $key = array_rand($articles);
            ++$count;
        }

        // key is already used
        if (in_array($key, $this->randomKeyByParam[$keyResearch], true)) {
            return null;
        }

        $this->randomKeyByParam[$keyResearch][] = $key;

        return $this->builder->build($articles[$key]);
    }

    public function findAll(array $param = []): array
    {
        $keyResearch = $this->createKey($param);

        if (!isset($this->recordsByParam[$keyResearch])) {
            $this->recordsByParam[$keyResearch] = [];
            $response = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl()),
                    $param,
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            foreach ($response['records'] as $rawData) {
                $this->recordsByParam[$keyResearch][$rawData['id']] = $this->builder->build($rawData);
            }

            while (isset($response['offset'])) {
                $param['offset'] = $response['offset'];
                $response = json_decode(
                    $this->airtableClient->request(
                        'GET',
                        sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl()),
                        $param,
                    ),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                foreach ($response['records'] as $rawData) {
                    $this->recordsByParam[$keyResearch][$rawData['id']] = $this->builder->build($rawData);
                }
            }
        }

        return $this->recordsByParam[$keyResearch];
    }

    public function getNbItems(): int
    {
        return count($this->findAll());
    }

    public function getById(string $id): ?BlockInterface
    {
        try {
            $response = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/%s/%s', $this->airtableAppId, $this->getFetchUrl(), $id),
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (ClientException $exception) {
            if ($exception->getCode() === 404) {
                return null;
            }

            throw $exception;
        }

        return $this->builder->build($response);
    }

    abstract protected function getFetchUrl(): string;

    private function createKey(array $param = []): string
    {
        return md5(serialize($param));
    }
}
