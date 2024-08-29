<?php
declare(strict_types=1);

namespace App\ValueObject\Children;

use Carbon\Carbon;

class Child
{
    public function __construct(
        private readonly string $firstName,
        private readonly Carbon $birthDay
    ) {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getBirthDay(): Carbon
    {
        return $this->birthDay;
    }

    public function getDaysSinceBirthDay(): int
    {
        return Carbon::now()->diffInDays($this->birthDay);
    }

    public function getWeeksSinceBirthDay(): int
    {
        return Carbon::now()->diffInWeeks($this->birthDay);
    }

    public function getMonthsSinceBirthDay(): int
    {
        return Carbon::now()->diffInMonths($this->birthDay);
    }

    public function getYearsSinceBirthDay(): int
    {
        return Carbon::now()->diffInYears($this->birthDay);
    }
}
