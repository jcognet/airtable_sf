<?php
declare(strict_types=1);

namespace App\Service\Contract;

use Carbon\Carbon;

interface PreviousOccurenceFetcherInterface
{
    public function getPreviousOccurence(Carbon $date): ?OccurenceInterface;
}
