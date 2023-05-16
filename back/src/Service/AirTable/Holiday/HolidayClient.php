<?php
declare(strict_types=1);

namespace App\Service\AirTable\Holiday;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Holiday\HolidayBuilder;

class HolidayClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppHollidayId,
        HolidayBuilder $holidayBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppHollidayId, $holidayBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Vacances';
    }
}
