<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use App\Service\Archive\AbstractReadWriteHandler;
use Carbon\Carbon;

class ReadWriteHandler extends AbstractReadWriteHandler
{
    protected function getFileName(Carbon $date): string
    {
        return sprintf('%s/citebebe_dates.json', $this->deployArchiveJsonPath);
    }
}
