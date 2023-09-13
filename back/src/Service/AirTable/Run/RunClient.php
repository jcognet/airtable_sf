<?php
declare(strict_types=1);

namespace App\Service\AirTable\Run;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Run\NextRunBuilder;

class RunClient extends AbstractClient
{
    public function __construct(
        string $airtableAppRunId,
        NextRunBuilder $nextRunBuilder
    ) {
        parent::__construct($airtableAppRunId, $nextRunBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Courses';
    }
}
