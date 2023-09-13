<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use Carbon\Carbon;

class Meat
{
    public function __construct(
        private readonly Carbon $date,
        private readonly bool $lunch,
        private readonly ?string $lunchComment,
        private readonly bool $dinner,
        private readonly ?string $dinnerComment,
    ) {}

    public function isLunch(): bool
    {
        return $this->lunch;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getLunchComment(): ?string
    {
        return $this->lunchComment;
    }

    public function isDinner(): bool
    {
        return $this->dinner;
    }

    public function getDinnerComment(): ?string
    {
        return $this->dinnerComment;
    }
}
