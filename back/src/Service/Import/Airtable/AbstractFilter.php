<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

abstract class AbstractFilter
{
    abstract public function filter(array $filter): ?array;
}
