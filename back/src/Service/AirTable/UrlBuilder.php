<?php
declare(strict_types=1);

namespace App\Service\AirTable;

class UrlBuilder
{
    public function build(
        string $tableId,
        string $tableUrl,
        string $viewUrl,
        string $id
    ): string {
        return sprintf(
            'https://airtable.com/%s/%s/%s/%s',
            $tableId,
            $tableUrl,
            $viewUrl,
            $id
        )
        ;
    }
}
