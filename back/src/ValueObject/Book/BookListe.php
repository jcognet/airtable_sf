<?php
declare(strict_types=1);

namespace App\ValueObject\Book;

use App\ValueObject\BlockInterface;

class BookListe implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'list_book';

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

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }
}
