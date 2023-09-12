<?php
declare(strict_types=1);

namespace App\Service\Export;

use App\Service\Archive\ExportWriterFetcher;
use Carbon\Carbon;

class Fetcher
{
    public function __construct(private readonly ExportWriterFetcher $exportWriterFetcher) {}

    public function fetch(Carbon $date): ?array
    {
        return $this->exportWriterFetcher->get($date);
    }
}
