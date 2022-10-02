<?php
declare(strict_types=1);

namespace App\Service\Repository\Beer;

use App\Service\AirTable\Beer\BreweryClient;
use App\ValueObject\Beer\Brewery;

class BreweryRepository
{
    private ?array $brasseries = null;

    public function __construct(private readonly BreweryClient $brasserieClient)
    {
    }

    public function getById(string $id): Brewery
    {
        if ($this->brasseries === null) {
            $this->get();
        }

        return $this->brasseries[$id];
    }

    private function get(): array
    {
        if ($this->brasseries === null) {
            $this->brasseries = $this->brasserieClient->findAll();
        }

        return $this->brasseries;
    }
}
