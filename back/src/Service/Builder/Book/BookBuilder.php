<?php
declare(strict_types=1);

namespace App\Service\Builder\Book;

use App\Service\AirTable\UrlBuilder;
use App\Service\Builder\BuilderInterface;
use App\ValueObject\Book\Book;

class BookBuilder implements BuilderInterface
{
    private const TABLE_URL = 'tblCntSAjTyDdgrwD';
    private const TABLE_VIEW_ID = 'viwBxmMvwl9x1lYi8';

    public function __construct(
        private readonly UrlBuilder $urlBuilder,
        private readonly string $airtableAppBookId
    ) {
    }

    public function build(array $data)
    {
        return new Book(
            $data['fields']['Livre'],
            $data['fields']['Citation / Analyse'] ?? '',
            $data['fields']['Status'] ?? null,
            $data['fields']['Auteur'] ?? null,
            $data['fields']['URL'] ?? null,
            $data['fields']['Page courante'] ?? null,
            $data['fields']['Page max'] ?? null,
            urlAirtable: $this->urlBuilder->build(
                $this->airtableAppBookId,
                self::TABLE_URL,
                self::TABLE_VIEW_ID,
                $data['id']
            )
        );
    }
}
