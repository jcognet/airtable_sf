<?php
declare(strict_types=1);

namespace App\Service\Fooding;

use App\Service\Import\Airtable\Fooding\Abs\Fetcher;
use Carbon\Carbon;

class AbsMissingCounter
{
    public function __construct(private readonly Fetcher $fetcher) {}

    public function countMissingAbs(Carbon $date): ?int
    {
        $absBeforeDate = $this->fetcher->fetchBefore($date);

        if (!$absBeforeDate) {
            return null;
        }

        $firstDay = reset($absBeforeDate);
        $nbDays = $date->diff($firstDay->getDate())->days;

        $nbAbs = 0;
        foreach ($absBeforeDate as $absDate) {
            if ($absDate->getQuantity() > 0) {
                $nbAbs += $absDate->getQuantity();

                continue;
            }

            if ($absDate->isExempt()) {
                ++$nbAbs;
            }
        }

        return $nbDays - $nbAbs;
    }
}
