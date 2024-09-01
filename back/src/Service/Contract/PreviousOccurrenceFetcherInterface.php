<?php
declare(strict_types=1);

namespace App\Service\Contract;

use Carbon\Carbon;

interface PreviousOccurrenceFetcherInterface
{
    public function getPreviousOccurrence(Carbon $date): ?OccurrenceInterface;
}
