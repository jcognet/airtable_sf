<?php
declare(strict_types=1);

namespace App\Service\Builder\File;

use App\Service\AirTable\UrlBuilder;
use App\Service\Builder\BuilderInterface;
use App\ValueObject\Article\File\File;

class FileBuilder implements BuilderInterface
{
    private const TABLE_URL = 'tblipmyJiUWVtVdYt';

    public function __construct(
        private readonly UrlBuilder $urlBuilder,
        private readonly string $airtableAppClientId
    ) {}

    public function build(array $data): File
    {
        $file = new File(
            id: $data['id'],
            title: $data['fields']['Nom'],
            url: $data['fields']['URL'],
            airTableUrl: $this->urlBuilder->build(
                $this->airtableAppClientId,
                self::TABLE_URL,
                $this->getViewUrl(),
                $data['id']
            )
        );

        $file->setAirtableTmpFileUrl($data['fields']['Fichier'][0]['url']);
        $file->setAirtableTmpFileName($data['fields']['Fichier'][0]['filename']);

        return $file;
    }

    private function getViewUrl(): string
    {
        return 'viwFAh9aljkWzgaY0';
    }
}
