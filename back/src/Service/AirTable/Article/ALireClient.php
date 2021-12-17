<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AirtableClient;
use App\Service\AirTable\FetchDataInterface;
use App\Service\Builder\Article\ArticleBuilder;
use App\ValueObject\BlockInterface;

class ALireClient implements FetchDataInterface
{
    private AirtableClient $airtableClient;
    private string $airtableAppArticleId;
    private ArticleBuilder $articleBuilder;
    private array $nbArticles = [];

    private ?array $records = [];

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleBuilder $articleBuilder
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppArticleId = $airtableAppArticleId;
        $this->articleBuilder = $articleBuilder;
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        $keyResearch = $this->createKey($param);

        if (!isset($this->records[$keyResearch])) {
            $this->records[$keyResearch] = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/A lire', $this->airtableAppArticleId),
                    $param,
                ),
                true
            )['records'];
        }

        $articles = $this->records[$keyResearch];
        $key = array_rand($articles);

        return $this->articleBuilder->build($articles[$key]);
    }

    public function getNbArticles(array $param = []): ?int
    {
        return isset($this->nbArticles[$this->createKey($param)]) ? count($this->nbArticles[$this->createKey($param)]) : null;
    }

    public function getNbAllArticles(): int
    {
        $nbArticles = 0;

        foreach ($this->records as $records) {
            $nbArticles += count($records);
        }

        return $nbArticles;
    }

    private function createKey(array $param = []): string
    {
        return md5(serialize($param));
    }
}
