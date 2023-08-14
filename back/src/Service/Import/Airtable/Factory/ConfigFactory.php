<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Factory;

use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Import\Airtable\IsImported;

class ConfigFactory
{
    public function __construct(
        private readonly iterable $configs,
        private readonly IsImported $isImported
    ) {
    }

    public function make(string $type): AirtableConfigInterface
    {
        foreach ($this->configs as $config) {
            if ($type === $config->getPublicKey()) {
                return $config;
            }
        }

        throw new UnknownDataImportedTypeException($type, array_map(fn (AirtableConfigInterface $config) => $config->getPublicKey(), $this->isImported->fetchAll()));
    }
}
