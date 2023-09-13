<?php
declare(strict_types=1);

namespace App\Service\AirTable\Holiday;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Holiday\HolidayBuilder;

class HolidayClient extends AbstractClient
{
    public function __construct(
        string $airtableAppHollidayId,
        HolidayBuilder $holidayBuilder
    ) {
        parent::__construct($airtableAppHollidayId, $holidayBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Vacances';
    }
}
