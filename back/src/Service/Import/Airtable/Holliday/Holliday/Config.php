<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Holliday\Holliday;

use App\Service\Import\Airtable\AbstractConfig;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'hollidays.json';
    }

    public function getSubPath(): string
    {
        return 'holliday/';
    }
}
