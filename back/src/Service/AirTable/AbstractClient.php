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

    private ?array $records = [];
    private array $nbArticles = [];

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

        if (!isset($this->records[$keyResearch])) {
            $this->records[$keyResearch] = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl()),
                    $param,
                ),
                true
            )['records'];
        }

        $articles = $this->records[$keyResearch];
        $key = array_rand($articles);

        return $this->builder->build($articles[$key]);
    }

    public function getNbAllArticles(): int
    {
        $nbArticles = 0;

        foreach ($this->records as $records) {
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
