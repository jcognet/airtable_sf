<?php
declare(strict_types=1);

namespace App\ValueObject\Archive;

use Carbon\Carbon;

class NewsLetter
{
    private Carbon $date;
    private string $content;
    private bool $wasSent;

    public function __construct(
        Carbon $date,
        string $content,
        bool $wasSent
    ) {
        $this->date = $date;
        $this->content = $content;
        $this->wasSent = $wasSent;
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
