<?php
declare(strict_types=1);

namespace App\ValueObject\Archive;

use App\ValueObject\BlockInterface;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class NewsLetter
{
    /**
     * @param BlockInterface[]|null $blocks
     */
    public function __construct(
        private readonly Carbon $date,
        private string $newsletterHtml,
        private bool $wasSent,
        private readonly Newspaper $newspaper
    ) {
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getNewsletterHtml(): string
    {
        return $this->newsletterHtml;
    }

    public function setNewsletterHtml(string $newsletterHtml): void
    {
        $this->newsletterHtml = $newsletterHtml;
    }

    public function wasSent(): bool
    {
        return $this->wasSent;
    }

    public function setWasSent(bool $wasSent): void
    {
        $this->wasSent = $wasSent;
    }

    public function getNewspaper(): Newspaper
    {
        return $this->newspaper;
    }
}
