<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

abstract class AbstractFilter
{
    public function filter(string $filter, array $items): array
    {
        $fields = $this->getFilterGetter();
        $cleanFilter = $this->cleanWord($filter);

        if (count($fields) === 0 || $cleanFilter === '') {
            return $items;
        }

        $filteredItems = [];

        foreach ($items as $item) {
            foreach ($fields as $field) {
                $getter = sprintf('get%s', ucfirst((string) $field));

                if (str_contains($this->cleanWord($item->{$getter}()), $filter)) {
                    $filteredItems[] = $item;

                    continue 2;
                }
            }
        }

        return $filteredItems;
    }

    abstract public function getFilterGetter(): array;

    private function cleanWord(string $filter): string
    {
        return strtolower(trim($filter));
    }
}
