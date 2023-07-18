<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Article\ArticleToReadBuilder;

class ALireClient extends AbstractClient
{
    public function __construct(
        string $airtableAppArticleId,
        ArticleToReadBuilder $articleBuilder
    ) {
        parent::__construct($airtableAppArticleId, $articleBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'A lire';
    }
}
