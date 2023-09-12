<?php
declare(strict_types=1);

namespace App\Service\AirTable\Fooding;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Fooding\CoffeeBuilder;

class CoffeeClient extends AbstractClient
{
    public function __construct(
        string $airtableAppFoodingId,
        CoffeeBuilder $coffeeBuilder
    ) {
        parent::__construct($airtableAppFoodingId, $coffeeBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Café';
    }
}
