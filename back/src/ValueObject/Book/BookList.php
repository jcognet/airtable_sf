<?php
declare(strict_types=1);

namespace App\ValueObject\Book;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class BookList implements BlockInterface
{
    /**
     * @param Book[] $books
     */
    public function __construct(private readonly ?string $title, private readonly array $books)
    {
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
