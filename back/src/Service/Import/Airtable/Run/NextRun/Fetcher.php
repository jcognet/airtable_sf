<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Run\NextRun;

use App\ValueObject\Run\NextRun;
use Carbon\Carbon;

class Fetcher
{
    public function __construct(
        private readonly Lister $lister
    ) {
    }

    public function fetchInFuture(): ?array
    {
        $now = Carbon::now();

        $nextRuns = [];
        $list = $this->lister->list();

        if ($list === null) {
            return null;
        }

        foreach ($list as $run) {
            /** @var NextRun $run */
            if ($run->getDate() === null) {
                continue;
            }

            if ($run->getDate() >= $now) {
                $nextRuns[] = $run;
            }
        }

        return $nextRuns;
    }
}
