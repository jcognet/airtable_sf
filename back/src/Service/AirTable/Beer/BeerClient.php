<?php
declare(strict_types=1);

namespace App\Service\AirTable\Beer;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Beer\BeerBuilder;

class BeerClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        BeerBuilder $beerBuilder,
        string $airtableAppBiereId
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $beerBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Bière';
    }
}
