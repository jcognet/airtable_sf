<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Service\Import\Airtable\Factory\ConfigFactory;

class IsFiltrable
{
    public function __construct(
        private readonly IsImported $isImported,
        private readonly ConfigFactory $configFactory,
        private readonly YamlListReader $yamlListReader,
    ) {}

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

        return count($this->yamlListReader->getFilters($config)) > 0;
    }
}
