<?php
declare(strict_types=1);

namespace App\Service\AirTable\Beer;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Beer\BeerBuilder;

class BeerClient extends AbstractClient
{
    public function __construct(
        string $airtableAppBiereId,
        BeerBuilder $beerBuilder
    ) {
        parent::__construct($airtableAppBiereId, $beerBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Bière';
    }
}
