<?php
declare(strict_types=1);

namespace App\Service\Alert;

use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

interface AlerterInterface
{
    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert;
}
