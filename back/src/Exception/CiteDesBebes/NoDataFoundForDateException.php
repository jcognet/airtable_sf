<?php
declare(strict_types=1);

namespace App\Exception\CiteDesBebes;

use Carbon\Carbon;

class NoDataFoundForDateException extends \RuntimeException
{
    public function __construct(Carbon $date, string $json)
    {
        parent::__construct(
            sprintf(
                'No data found for "%s". JSON : %s',
                $date->format('d/m/Y'),
                $json
            ),
        );
    }
}
