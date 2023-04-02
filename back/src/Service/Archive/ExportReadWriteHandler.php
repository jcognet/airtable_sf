<?php
declare(strict_types=1);

namespace App\Service\Archive;

use Carbon\Carbon;

class ExportReadWriteHandler extends AbstractReadWriteHandler
{
    protected function getFileName(Carbon $date): string
    {
        return sprintf('%s/%s_export.json', $this->deployArchiveJsonPath, $date->format('Y-m-d'));
    }
}
