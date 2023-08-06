<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Book\Book;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Book\Book;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'books.json';
    }

    public function getSubPath(): string
    {
        return 'book/';
    }

    public function getDataEntryName(): string
    {
        return 'books';
    }

    public function getClass(): string
    {
        return Book::class;
    }

    public function getPublicKey(): string
    {
        return 'book';
    }

    public function getPublicLabel(): string
    {
        return 'livres';
    }
}
