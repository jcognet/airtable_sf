<?php
declare(strict_types=1);

namespace App\Service\AirTable\Beer;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Beer\BeerBuilder;
use App\ValueObject\Beer\Beer;

class BeerClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        BeerBuilder $beerBuilder,
        string $airtableAppBiereId
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $beerBuilder);
    }

    public function fetchRandomData(array $param = []): ?Beer
    {
        return parent::fetchRandomData($param);
    }

    /**
     * @return Beer[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    protected function getFetchUrl(): string
    {
        return 'Bière';
    }
}
