<?php
declare(strict_types=1);

namespace App\Service\AirTable\Fooding;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Fooding\ColoringBuilder;

class ColoringClient extends AbstractClient
{
    public function __construct(
        string $airtableAppFoodingId,
        ColoringBuilder $coloringBuilder
    ) {
        parent::__construct($airtableAppFoodingId, $coloringBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Teinte';
    }
}
