<?php
declare(strict_types=1);

namespace App\Service\AirTable\Run;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Run\NextRunBuilder;

class RunClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        NextRunBuilder $nextRunBuilder,
        string $airtableAppRunId
    ) {
        parent::__construct($airtableClient, $airtableAppRunId, $nextRunBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Courses';
    }
}
