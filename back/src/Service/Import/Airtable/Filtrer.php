<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Service\Contract\AirtableConfigInterface;
use App\ValueObject\Import\Airtable\Filter;

class Filtrer
{
    public function __construct(
        private readonly IsFiltrable $isFiltrable,
        private readonly YamlListReader $yamlListReader
    ) {}

    public function filter(
        AirtableConfigInterface $config,
        string $filter,
        array $items
    ): array {
        if (!$this->isFiltrable->isFiltrable($config->getPublicKey())) {
            return $items;
        }

        $cleanFilter = $this->cleanWord($filter);
        $fields = $this->yamlListReader->getFilters($config);

        if (count($fields) === 0 || $cleanFilter === '') {
            return $items;
        }

        $filteredItems = [];

        foreach ($items as $item) {
            /**
             * @var Filter $field
             */
            foreach ($fields as $field) {
                $getter = sprintf('get%s', ucfirst($field->getProperty()));

                if (str_contains($this->cleanWord($item->{$getter}()), $filter)) {
                    $filteredItems[] = $item;

                    continue 2;
                }
            }
        }

        return $filteredItems;
    }

    private function cleanWord(string $filter): string
    {
        return strtolower(trim($filter));
    }
}
