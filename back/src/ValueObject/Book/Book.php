<?php
declare(strict_types=1);

namespace App\ValueObject\Book;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Book extends AbstractBlock
{
    public function __construct(
        private readonly string $title,
        private readonly string $body,
        private readonly ?string $status,
        private readonly ?string $auteur,
        private readonly ?string $url,
        private readonly ?int $currentPage,
        private readonly ?int $maxPage,
        private readonly string $urlAirtable
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->body;
    }

    public function getType(): BlockType
    {
        return BlockType::BOOK_BLOCK;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getCurrentPage(): ?int
    {
        return $this->currentPage;
    }

    public function getMaxPage(): ?int
    {
        return $this->maxPage;
    }

    public function getUrlAirtable(): string
    {
        return $this->urlAirtable;
    }

    public function percentPageRead(): ?float
    {
        if ($this->currentPage === null || $this->maxPage === null) {
            return null;
        }

        return round($this->currentPage / $this->maxPage) * 100;
    }
}
