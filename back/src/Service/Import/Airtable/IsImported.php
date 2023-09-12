<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Service\Contract\AirtableConfigInterface;

class IsImported
{
    public function __construct(
        private readonly iterable $configs
    ) {}

    public function isImported(string $type): bool
    {
        /** @var AirtableConfigInterface $config */
        foreach ($this->configs as $config) {
            if ($type === $config->getPublicKey()) {
                return true;
            }
        }

        return false;
    }

    /**
     * AirtableConfigInterface[]
     */
    public function fetchAll(): array
    {
        $data = [];
        /** @var AirtableConfigInterface $config */
        foreach ($this->configs as $config) {
            $data[] = $config;
        }

        return $data;
    }
}
