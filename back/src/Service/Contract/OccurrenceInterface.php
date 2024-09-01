<?php
declare(strict_types=1);

namespace App\Service\Contract;

use Carbon\Carbon;

interface OccurrenceInterface
{
    public function getDate(): Carbon;
}
