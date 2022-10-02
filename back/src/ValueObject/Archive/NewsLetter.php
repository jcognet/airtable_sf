<?php
declare(strict_types=1);

namespace App\ValueObject\Archive;

use Carbon\Carbon;

class NewsLetter
{
    public function __construct(private readonly Carbon $date, private readonly string $content, private bool $wasSent)
    {
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function wasSent(): bool
    {
        return $this->wasSent;
    }

    public function setWasSent(bool $wasSent): void
    {
        $this->wasSent = $wasSent;
    }
}
