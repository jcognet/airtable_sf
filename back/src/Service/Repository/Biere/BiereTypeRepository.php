<?php
declare(strict_types=1);

namespace App\Service\Repository\Biere;

use App\Service\AirTable\Biere\BiereTypeClient;
use App\ValueObject\Biere\BiereType;

class BiereTypeRepository
{
    private ?array $types = null;
    private BiereTypeClient $biereTypeClient;

    public function __construct(BiereTypeClient $biereTypeClient)
    {
        $this->biereTypeClient = $biereTypeClient;
    }

    public function getById(string $id): BiereType
    {
        if ($this->types === null) {
            $this->get();
        }

        return $this->types[$id];
    }

    private function get(): array
    {
        if ($this->types === null) {
            $this->types = $this->biereTypeClient->findAll();
        }

        return $this->types;
    }
}
