<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use Carbon\Carbon;

class Coffee
{
    public function __construct(
        private readonly Carbon $date,
        private readonly int $quantity,
        private readonly ?string $comment
    ) {}

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
