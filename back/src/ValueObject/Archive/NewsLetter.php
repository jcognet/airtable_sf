<?php
declare(strict_types=1);

namespace App\ValueObject\Archive;

use App\ValueObject\BlockInterface;
use Carbon\Carbon;

class NewsLetter
{
    /**
     * @param BlockInterface[]|null $blocks
     */
    public function __construct(
        private readonly Carbon $date,
        private readonly string $newsletterHtml,
        private bool $wasSent,
        private readonly ?array $blocks
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

    public function wasSent(): bool
    {
        return $this->wasSent;
    }

    public function setWasSent(bool $wasSent): void
    {
        $this->wasSent = $wasSent;
    }

    /**
     * @return BlockInterface[]|null
     */
    public function getBlocks(): ?array
    {
        return $this->blocks;
    }
}
