<?php
declare(strict_types=1);

namespace App\ValueObject\Import\Airtable;

class ImportedData
{
    /**
     * @param Field[] $fields
     */
    public function __construct(
        private readonly string $label,
        private readonly array $fields,
        private readonly ?array $data
    ) {}

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
