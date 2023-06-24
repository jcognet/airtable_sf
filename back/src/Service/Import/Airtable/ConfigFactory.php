<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Service\Contract\AirtableConfigInterface;

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

        throw new UnknownDataImportedTypeException($type, $this->isImported->fetchAll());
    }
}
