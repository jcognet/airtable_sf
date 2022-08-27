<?php
declare(strict_types=1);

namespace App\Service\Builder\Book;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Book\Book;

class BookBuilder implements BuilderInterface
{
    public function build(array $data)
    {
        return new Book(
            $data['fields']['Livre'],
            $data['fields']['Citation / Analyse'] ?? '',
            $data['fields']['Status'] ?? null,
            $data['fields']['Auteur'] ?? null,
            $data['fields']['URL'] ?? null,
            $data['fields']['Page courante'] ?? null,
            $data['fields']['Page max'] ?? null
        );
    }
}
