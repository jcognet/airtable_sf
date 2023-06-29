<?php
declare(strict_types=1);

namespace App\ValueObject\Import\Airtable;

class Field
{
    public function __construct(
        private readonly string $property,
        private readonly ?string $label = null,
        private readonly bool $isSortable = false,
    ) {
    }

    public function getLabel(): string
    {
        if ($this->label === null) {
            return $this->property;
        }

        return $this->label;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function isSortable(): bool
    {
        return $this->isSortable;
    }
}
