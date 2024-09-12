<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\NoFileYamlException;
use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Import\Airtable\Factory\ConfigFactory;

class IsListable
{
    public function __construct(
        private readonly IsImported $isImported,
        private readonly YamlListReader $yamlListReader,
        private readonly ConfigFactory $configFactory
    ) {}

    public function isListable(string $type): bool
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
            $this->yamlListReader->getFields($config);
        } catch (NoFileYamlException) {
            return false;
        }

        return true;
    }

    public function fetchAll(): array
    {
        $typeListable = [];

        foreach ($this->isImported->fetchAll() as $type) {
            if ($this->isListable($type->getPublicKey())) {
                $typeListable[] = $type;
            }
        }

        usort($typeListable, static fn (AirtableConfigInterface $a, AirtableConfigInterface $b) => strtolower($a->getPublicLabel()) <=> strtolower($b->getPublicLabel()));

        return $typeListable;
    }
}
