<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use Carbon\Carbon;

class Currency
{
    private string $symbol;
    private float $value;
    private Carbon $date;

    public function __construct(
        string $symbol,
        float $value,
        Carbon $date
    ) {
        $this->symbol = $symbol;
        $this->value = $value;
        $this->date = $date;
    }

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
