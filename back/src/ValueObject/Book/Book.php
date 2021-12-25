<?php
declare(strict_types=1);

namespace App\ValueObject\Book;

use App\ValueObject\BlockInterface;

class Book implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'book';

    private string $title;
    private string $body;
    private ?string $status;
    private ?string $auteur;
    private ?string $url;
    private ?int $currentPage;
    private ?int $maxPage;

    public function __construct(string $title, string $body, ?string $status, ?string $auteur, ?string $url, ?int $currentPage, ?int $maxPage)
    {
        $this->title = $title;
        $this->body = $body;
        $this->status = $status;
        $this->auteur = $auteur;
        $this->url = $url;
        $this->currentPage = $currentPage;
        $this->maxPage = $maxPage;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->body;
    }

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
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

    public function percentPageRead(): ?float
    {
        if ($this->currentPage === null || $this->maxPage === null) {
            return null;
        }

        return round(($this->currentPage / $this->maxPage)) * 100;
    }
}
