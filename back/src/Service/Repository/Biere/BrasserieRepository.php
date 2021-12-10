<?php
declare(strict_types=1);

namespace App\Service\Repository\Biere;

use App\Service\AirTable\Biere\BrasserieClient;
use App\ValueObject\Biere\Brasserie;

class BrasserieRepository
{
    private ?array $brasseries = null;
    private BrasserieClient $brasserieClient;

    public function __construct(BrasserieClient $brasserieClient)
    {
        $this->brasserieClient = $brasserieClient;
    }

    public function getById(string $id): Brasserie
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
