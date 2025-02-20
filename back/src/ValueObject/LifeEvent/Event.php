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
        return (int) $this->date->diffInDays(Carbon::now());
    }

    public function getWeeksSinceDate(): int
    {
        return (int) $this->date->diffInWeeks(Carbon::now());
    }

    public function getMonthsSinceDate(): int
    {
        return (int) Carbon::now()->diffInMonths($this->date);
    }

    public function getYearsSinceDate(): int
    {
        return (int) Carbon::now()->diffInYears($this->date);
    }
}
