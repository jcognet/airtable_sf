<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Exception\Import\Airtable\UnknownFilterServiceException;
use App\Service\Import\Airtable\Factory\ConfigFactory;
use App\Service\Import\Airtable\Factory\ImportedDataFilterFactory;

class IsFiltrable
{
    public function __construct(
        private readonly IsImported $isImported,
        private readonly ImportedDataFilterFactory $importedDataFilterFactory,
        private readonly ConfigFactory $configFactory,
        private readonly YamlListReader $yamlListReader,
    ) {
    }

    public function isFiltrable(string $type): bool
    {
        if (!$this->isImported->isImported($type)) {
            return false;
        }

        try {
            $config = $this->configFactory->make($type);
        } catch (UnknownDataImportedTypeException) {
            return false;
        }

        try {
            $this->importedDataFilterFactory->make($config);
        } catch (UnknownFilterServiceException) {
            return false;
        }

        return count($this->yamlListReader->getFilters($config)) > 0;
    }
}
