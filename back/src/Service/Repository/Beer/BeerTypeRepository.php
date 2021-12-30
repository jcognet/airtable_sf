<?php
declare(strict_types=1);

namespace App\Service\Repository\Beer;

use App\Service\AirTable\Beer\BeerTypeClient;
use App\ValueObject\Beer\BeerType;

class BeerTypeRepository
{
    private ?array $types = null;
    private BeerTypeClient $beerTypeClient;

    public function __construct(BeerTypeClient $beerTypeClient)
    {
        $this->beerTypeClient = $beerTypeClient;
    }

    public function getById(string $id): BeerType
    {
        if ($this->types === null) {
            $this->get();
        }

        return $this->types[$id];
    }

    private function get(): array
    {
        if ($this->types === null) {
            $this->types = $this->beerTypeClient->findAll();
        }

        return $this->types;
    }
}
