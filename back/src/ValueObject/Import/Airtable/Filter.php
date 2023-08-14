<?php
declare(strict_types=1);

namespace App\ValueObject\Import\Airtable;

class Filter
{
    public function __construct(
        private readonly string $property,
    ) {
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
