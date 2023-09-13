<?php
declare(strict_types=1);

namespace App\Service\Block\Run;

use App\Service\Block\BlockManagerInterface;
use App\Service\Import\Airtable\Run\NextRun\Fetcher;
use App\ValueObject\BlockInterface;
use App\ValueObject\Run\ListBlockNextRun;

class NextRunBlockManager implements BlockManagerInterface
{
    public function __construct(private readonly Fetcher $fetcher) {}

    public function getContent(): ?BlockInterface
    {
        $nextRuns = $this->fetcher->fetchInFuture();

        if ($nextRuns === null || count($nextRuns) === 0) {
            return null;
        }

        return new ListBlockNextRun(
            $nextRuns
        );
    }
}
