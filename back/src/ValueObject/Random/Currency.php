<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use Carbon\Carbon;

class Currency
{
    public function __construct(
        private readonly string $symbol,
        private readonly float $value,
        private readonly Carbon $date
    ) {}

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }
}
