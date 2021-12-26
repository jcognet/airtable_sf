<?php
declare(strict_types=1);

namespace App\Service\Block\Book;

use App\Service\AirTable\Book\BookClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class BookBlockManager implements BlockManagerInterface
{
    private BookClient $bookClient;

    public function __construct(BookClient $bookClient)
    {
        $this->bookClient = $bookClient;
    }

    public function getContent(): ?BlockInterface
    {
        return $this->bookClient->fetchRandomData(['filterByFormula' => '{Status} = "Fini"']);
    }
}
