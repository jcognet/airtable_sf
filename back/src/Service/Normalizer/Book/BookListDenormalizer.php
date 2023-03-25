<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Book;

use App\ValueObject\Book\Book;
use App\ValueObject\Book\BookList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BookListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): BookList
    {
        $bookDenormalizer = new BookDenormalizer();
        $books = [];

        foreach ($data['content'] as $book) {
            $books[] = $bookDenormalizer->denormalize($book, Book::class);
        }

        $data['books'] = $books;
        unset($data['content'], $data['class']);

        return new BookList(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === BookList::class;
    }
}
