<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Article\ArticleToReadBuilder;
use App\ValueObject\Article\Article;
use App\ValueObject\Article\Concept;

class ConceptClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleToReadBuilder $articleBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppArticleId, $articleBuilder);
    }

    public function fetchRandomData(array $param = []): ?Concept
    {
        return parent::fetchRandomData($param);
    }

    /**
     * @return Article[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    protected function getFetchUrl(): string
    {
        return 'Concept';
    }
}
