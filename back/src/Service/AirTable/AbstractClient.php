<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\BlockInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractClient
{
    private const NB_TRY_RANDOM = 5;

    protected ?AirtableClient $airtableClient = null;
    private array $recordsByParam = [];
    private array $randomKeyByParam = [];

    private LastUsedManager $lastUsedManager;
    private LoggerInterface $logger;

    public function __construct(
        protected readonly string $airtableAppId,
        private readonly BuilderInterface $builder
    ) {
    }

    #[Required]
    public function setLastUsedManager(LastUsedManager $lastUsedManager): void
    {
        $this->lastUsedManager = $lastUsedManager;
    }

    #[Required]
    public function setAirtableClient(AirtableClient $airtableClient): void
    {
        $this->airtableClient = $airtableClient;
    }

    #[Required]
    public function setLoggerInterface(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        $keyResearch = $this->createKey($param);

        if (!isset($this->recordsByParam[$keyResearch])) {
            $this->findAll($param);
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

        // key is already used and we are at the max attempt => we stop there.
        if (in_array($key, $this->randomKeyByParam[$keyResearch], true)) {
            return null;
        }

        $this->randomKeyByParam[$keyResearch][] = $key;

        return $articles[$key];
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
                $object = $this->builder->build($rawData);
                $this->lastUsedManager->onPostBuild($object, $rawData);
                $this->recordsByParam[$keyResearch][$rawData['id']] = $object;
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
                    $object = $this->builder->build($rawData);
                    $this->lastUsedManager->onPostBuild($object, $rawData);
                    $this->recordsByParam[$keyResearch][$rawData['id']] = $object;
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

        $object = $this->builder->build($response);
        $this->lastUsedManager->onPostBuild($object, $response);

        return $object;
    }

    public function updateLastUsed(mixed $object): void
    {
        if ($this->lastUsedManager->supports($object::class)) {
            $payload = [
                'json' => [
                    'records' => [
                        $this->lastUsedManager->unBuild($object),
                    ],
                ],
            ];
            $url = sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl());

            try {
                $this->airtableClient->rawRequest(
                    'PATCH',
                    $url,
                    $payload
                );
            } catch (ClientException $exception) {
                $this->logger->error(
                    $exception->getMessage(),
                    [
                        'payload' => $payload,
                        'url' => $url,
                    ]
                );

                throw $exception;
            }
        }
    }

    abstract protected function getFetchUrl(): string;

    private function createKey(array $param = []): string
    {
        return md5(serialize($param));
    }
}
