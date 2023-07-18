<?php
declare(strict_types=1);

namespace App\Service\AirTable\Book;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Book\BookBuilder;

class BookClient extends AbstractClient
{
    public function __construct(
        string $airtableAppBookId,
        BookBuilder $bookBuilder
    ) {
        parent::__construct($airtableAppBookId, $bookBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Liste des livres';
    }
}
