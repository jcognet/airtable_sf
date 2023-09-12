<?php
declare(strict_types=1);

namespace App\Service\AirTable\Fooding;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Fooding\MeatBuilder;

class MeatClient extends AbstractClient
{
    public function __construct(
        string $airtableAppFoodingId,
        MeatBuilder $meatBuilder
    ) {
        parent::__construct($airtableAppFoodingId, $meatBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Viande';
    }
}
