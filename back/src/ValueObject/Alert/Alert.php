<?php
declare(strict_types=1);

namespace App\ValueObject\Alert;

use Carbon\Carbon;

class Alert
{
    public function __construct(
        private readonly string $message,
        private readonly Carbon $lastDate,
        private readonly int $nbDays,
        private readonly LevelEnum $level,
    ) {}

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLastDate(): Carbon
    {
        return $this->lastDate;
    }

    public function getNbDays(): int
    {
        return $this->nbDays;
    }

    public function getLevel(): LevelEnum
    {
        return $this->level;
    }
}
