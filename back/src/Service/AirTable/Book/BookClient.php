<?php
declare(strict_types=1);

namespace App\Service\AirTable\Book;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Book\BookBuilder;
use App\ValueObject\Book\Book;

class BookClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        BookBuilder $bookBuilder,
        string $airtableAppBookId
    ) {
        parent::__construct($airtableClient, $airtableAppBookId, $bookBuilder);
    }

    public function fetchRandomData(array $param = []): ?Book
    {
        return parent::fetchRandomData($param);
    }

    /**
     * @return Book[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    protected function getFetchUrl(): string
    {
        return 'Liste des livres';
    }
}
