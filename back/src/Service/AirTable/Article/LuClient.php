<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Article\ArticleReadBuilder;

class LuClient extends AbstractClient
{
    public function __construct(
        string $airtableAppArticleId,
        ArticleReadBuilder $articleBuilder
    ) {
        parent::__construct($airtableAppArticleId, $articleBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Lu';
    }
}
