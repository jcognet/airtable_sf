<?php
declare(strict_types=1);

namespace App\ValueObject\Book;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class BookListe implements BlockInterface
{
    private ?string $title;
    /**
     * @var Book[]
     */
    private array $books;

    public function __construct(
        string $title,
        array $bieres
    ) {
        $this->title = $title;
        $this->books = $bieres;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->books;
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::LIST_BOOK_BLOCK);
    }
}
