<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Biere\BiereBuilder;

class BiereClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        BiereBuilder $biereBuilder,
        string $airtableAppBiereId
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $biereBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Bière';
    }
}
