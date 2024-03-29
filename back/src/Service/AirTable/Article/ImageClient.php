<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Article\ImageBuilder;

class ImageClient extends AbstractClient
{
    public function __construct(
        string $airtableAppArticleId,
        ImageBuilder $imageBuilder
    ) {
        parent::__construct($airtableAppArticleId, $imageBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Image intéressante';
    }
}
