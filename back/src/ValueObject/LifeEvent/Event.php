<?php
declare(strict_types=1);

namespace App\ValueObject\LifeEvent;

use Carbon\Carbon;

class Event
{
    public function __construct(
        private readonly string $label,
        private readonly Carbon $date
    ) {}

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getDaysSinceDate(): int
    {
        return Carbon::now()->diffInDays($this->date);
    }

    public function getWeeksSinceDate(): int
    {
        return Carbon::now()->diffInWeeks($this->date);
    }

    public function getMonthsSinceDate(): int
    {
        return Carbon::now()->diffInMonths($this->date);
    }

    public function getYearsSinceDate(): int
    {
        return Carbon::now()->diffInYears($this->date);
    }
}
