<?php
declare(strict_types=1);

namespace App\ValueObject\Run;

use Carbon\Carbon;

class NextRun
{
    public function __construct(
        private readonly ?string $title,
        private readonly ?Carbon $date,
        private readonly ?int $distance,
        private readonly ?string $url,
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function remainingDays(): int
    {
        if ($this->date === null) {
            return 0;
        }

        return $this->date->diffInDays(Carbon::now());
    }
}
