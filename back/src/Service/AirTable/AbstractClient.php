<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\BlockInterface;

abstract class AbstractClient
{
    private AirtableClient $airtableClient;
    private string $airtableAppId;
    private BuilderInterface $builder;

    private array $recordsByParam = [];
    private array $records = [];

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppId,
        BuilderInterface $builder
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppId = $airtableAppId;
        $this->builder = $builder;
    }

    public function fetchRandomData(array $param = []): BlockInterface
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
        $key = array_rand($articles);

        return $this->builder->build($articles[$key]);
    }

    public function findAll(array $param = []): array
    {
        if (count($this->records) > 0) {
            return $this->records;
        }

        $response = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl()),
                $param,
            ),
            true
        );

        foreach ($response['records'] as $rawData) {
            $this->records[$rawData['id']] = $this->builder->build($rawData);
        }

        return $this->records;
    }

    public function getNbAllArticles(): int
    {
        $nbArticles = 0;

        foreach ($this->recordsByParam as $records) {
            $nbArticles += count($records);
        }

        return $nbArticles;
    }

    abstract protected function getFetchUrl(): string;

    private function createKey(array $param = []): string
    {
        return md5(serialize($param));
    }
}
