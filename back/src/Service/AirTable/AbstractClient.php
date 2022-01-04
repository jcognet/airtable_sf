<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\BlockInterface;

abstract class AbstractClient
{
    private const NB_TRI_RANDOM = 15;

    private AirtableClient $airtableClient;
    private string $airtableAppId;
    private BuilderInterface $builder;

    private array $recordsByParam = [];
    private $randomKeyByParam = [];

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppId,
        BuilderInterface $builder
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppId = $airtableAppId;
        $this->builder = $builder;
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
                true
            )['records'];
        }

        $articles = $this->recordsByParam[$keyResearch];
        if (count($articles) === 0) {
            return null;
        }

        $key = array_rand($articles);

        if (!isset($this->randomKeyByParam[$keyResearch])) {
            $this->randomKeyByParam[$keyResearch] = [];
        }

        $count = 0;
        while ($count < self::NB_TRI_RANDOM && in_array($key, $this->randomKeyByParam[$keyResearch], true)) {
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
                true
            );

            foreach ($response['records'] as $rawData) {
                $this->recordsByParam[$keyResearch][$rawData['id']] = $this->builder->build($rawData);
            }
        }

        return $this->recordsByParam[$keyResearch];
    }

    public function getNbAllArticles(): int
    {
        return count($this->findAll());
    }

    abstract protected function getFetchUrl(): string;

    private function createKey(array $param = []): string
    {
        return md5(serialize($param));
    }
}
