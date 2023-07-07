<?php
declare(strict_types=1);

namespace App\Service\AirTable\File;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\File\FileBuilder;

class FileClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppClientId,
        FileBuilder $fileBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppClientId, $fileBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Liste';
    }
}
