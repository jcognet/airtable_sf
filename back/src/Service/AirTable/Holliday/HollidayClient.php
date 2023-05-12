<?php
declare(strict_types=1);

namespace App\Service\AirTable\Holliday;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Holliday\HollidayBuilder;

class HollidayClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppHollidayId,
        HollidayBuilder $hollidayBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppHollidayId, $hollidayBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Vacances';
    }
}
