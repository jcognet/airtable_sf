<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Run\NextRun;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Run\NextRun;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'next_runs.json';
    }

    public function getSubPath(): string
    {
        return 'next_run/';
    }

    public function getDataEntryName(): string
    {
        return 'next_runs';
    }

    public function getClass(): string
    {
        return NextRun::class;
    }
}
