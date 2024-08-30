<?php
declare(strict_types=1);

namespace App\Service\Fooding;

use App\Service\Import\Airtable\Fooding\Abs\Fetcher;
use Carbon\Carbon;

class AbsSeriesCounter extends AbstractSeriesCounter
{
    public function __construct(private readonly Fetcher $fetcher) {}

    protected function fetchBefore(Carbon $date): ?array
    {
        return $this->fetcher->fetchBefore($date);
    }
}
