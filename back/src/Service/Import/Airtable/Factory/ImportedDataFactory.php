<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Factory;

use App\Service\Import\Airtable\YamlListReader;
use App\ValueObject\Import\Airtable\ImportedData;
use App\ValueObject\Import\Airtable\Sort;

class ImportedDataFactory
{
    public function __construct(
        private readonly ConfigFactory $configFactory,
        private readonly YamlListReader $yamlListReader,
        private readonly ImportedDataListFactory $importedDataClassFactory
    ) {
    }

    public function make(
        string $type,
        ?Sort $sort,
        ?string $filter
    ): ImportedData {
        $config = $this->configFactory->make($type);
        $lister = $this->importedDataClassFactory->make($config);

        return new ImportedData(
            label: $config->getPublicLabel(),
            fields: $this->yamlListReader->getFields($config),
            data: $lister->list($sort, $filter)
        );
    }
}
