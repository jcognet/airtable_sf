<?php
declare(strict_types=1);

namespace App\Service\Block\Book;

use App\Service\AirTable\Book\BookClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Book\BookListe;

class BookListBlockManager implements BlockManagerInterface
{
    private BookClient $bookClient;

    public function __construct(BookClient $bookClient)
    {
        $this->bookClient = $bookClient;
    }

    public function getContent(): BlockInterface
    {
        return new BookListe(
            'Bouquins en cours',
            $this->bookClient->findAll(['filterByFormula' => '{Status} = "En cours"'])
        );
    }
}
