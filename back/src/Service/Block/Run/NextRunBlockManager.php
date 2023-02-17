<?php
declare(strict_types=1);

namespace App\Service\Block\Run;

use App\Service\AirTable\Run\RunClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Run\ListBlockNextRun;
use Carbon\Carbon;

class NextRunBlockManager implements BlockManagerInterface
{
    public function __construct(private readonly RunClient $runClient)
    {
    }

    public function getContent(): ?BlockInterface
    {
        $nextRuns = $this->runClient->findAll(
            ['filterByFormula' => sprintf('IS_AFTER({Date}, "%s")', Carbon::now()->format('Y-m-d'))]
        );

        if (count($nextRuns) === 0) {
            return null;
        }

        return new ListBlockNextRun(
            $nextRuns
        );
    }
}
