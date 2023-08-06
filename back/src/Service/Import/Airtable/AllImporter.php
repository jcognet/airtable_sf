<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Service\Contract\AirtableImporterInterface;
use Psr\Log\LoggerInterface;

class AllImporter
{
    public function __construct(
        private readonly iterable $importers,
        private readonly LoggerInterface $logger
    ) {
    }

    public function import(?string $class): array
    {
        $data = [];
        /**
         * @var AirtableImporterInterface $importer
         */
        foreach ($this->importers as $importer) {
            if ($class && $class !== $importer::class) {
                continue;
            }

            $this->logger->info(
                sprintf(
                    'Start import of %s',
                    $importer->getLabel(),
                )
            );
            $items = $importer->import();
            $this->logger->info(
                sprintf(
                    'Items of %s were imported in %s. %d items found.',
                    $importer->getLabel(),
                    $importer->getConfig()->getCompleteName(),
                    count($items)
                )
            );
            $data[$importer->getLabel()] = count($items);
        }

        return $data;
    }
}
