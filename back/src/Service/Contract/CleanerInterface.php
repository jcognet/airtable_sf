<?php
declare(strict_types=1);

namespace App\Service\Contract;

use Carbon\Carbon;

interface CleanerInterface
{
    public function clean(Carbon $from): int;
}
