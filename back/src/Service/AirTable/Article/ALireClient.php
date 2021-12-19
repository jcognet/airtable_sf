<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Article\ArticleBuilder;

class ALireClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleBuilder $articleBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppArticleId, $articleBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'A lire';
    }
}
