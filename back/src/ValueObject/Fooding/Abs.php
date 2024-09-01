<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use App\Service\Contract\OccurrenceInterface;
use Carbon\Carbon;

class Abs implements OccurrenceInterface
{
    public function __construct(
        private readonly Carbon $date,
        private readonly ?string $comment,
        private readonly int $quantity,
        private readonly bool $isExempt
    ) {}

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function isExempt(): bool
    {
        return $this->isExempt;
    }
}
