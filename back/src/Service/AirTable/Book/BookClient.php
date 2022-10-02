<?php
declare(strict_types=1);

namespace App\Service\AirTable\Book;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Book\BookBuilder;

class BookClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        BookBuilder $bookBuilder,
        string $airtableAppBookId
    ) {
        parent::__construct($airtableClient, $airtableAppBookId, $bookBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Liste des livres';
    }
}
