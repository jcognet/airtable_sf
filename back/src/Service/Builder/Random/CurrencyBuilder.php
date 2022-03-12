<?php
declare(strict_types=1);

namespace App\Service\Builder\Random;

use App\ValueObject\Random\Currency;
use Carbon\Carbon;

class CurrencyBuilder
{
    public function build(array $data): Currency
    {
        return new Currency(
            $data['symbol'],
            $data['value'],
            Carbon::parse($data['date'])
        );
    }
}
