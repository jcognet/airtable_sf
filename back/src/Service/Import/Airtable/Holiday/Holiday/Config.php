<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Holiday\Holiday;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Holiday\Holiday;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'holidays.json';
    }

    public function getSubPath(): string
    {
        return 'holiday/';
    }

    public function getDataEntryName(): string
    {
        return 'holidays';
    }

    public function getClass(): string
    {
        return Holiday::class;
    }
}
