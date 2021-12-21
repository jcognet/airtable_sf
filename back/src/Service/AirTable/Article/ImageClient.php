<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Article\ImageBuilder;
use App\ValueObject\Article\Image;

class ImageClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ImageBuilder $imageBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppArticleId, $imageBuilder);
    }

    public function fetchRandomData(array $param = []): Image
    {
        return parent::fetchRandomData($param);
    }

    /**
     * @return Image[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    protected function getFetchUrl(): string
    {
        return 'Image intéressante';
    }
}
