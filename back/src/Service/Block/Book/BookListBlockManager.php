<?php
declare(strict_types=1);

namespace App\Service\Block\Book;

use App\Service\AirTable\Book\BookClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Book\BookList;

class BookListBlockManager implements BlockManagerInterface
{
    public function __construct(private readonly BookClient $bookClient) {}

    public function getContent(): ?BlockInterface
    {
        return new BookList(
            'Bouquins en cours',
            $this->bookClient->findAll(['filterByFormula' => '{Status} = "En cours"'])
        );
    }
}
