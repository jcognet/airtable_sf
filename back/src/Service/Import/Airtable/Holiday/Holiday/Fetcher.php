<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Holiday\Holiday;

use App\ValueObject\Holiday\Holiday;
use Carbon\Carbon;

class Fetcher
{
    public function __construct(private readonly Lister $lister) {}

    /**
     * @return Holiday[]|null
     */
    public function fetchFromDate(Carbon $date): ?array
    {
        $list = $this->lister->list();
        $dateReference = $date->copy()->startOfDay();

        if ($list === null) {
            return null;
        }

        $holidays = [];
        foreach ($list as $holiday) {
            /** @var Holiday $holiday */
            if ($dateReference >= $holiday->getStartDate() && $dateReference <= $holiday->getEndDate()) {
                $holidays[] = $holiday;
            }
        }

        return $holidays;
    }
}
