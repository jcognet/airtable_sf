<?php
declare(strict_types=1);

namespace App\Service\Repository;

use App\Service\AirTable\SujetClient;
use App\ValueObject\Sujet;

class SujetList
{
    private SujetClient $sujetClient;
    private ?array $sujets = null;

    public function __construct(SujetClient $sujetClient)
    {
        $this->sujetClient = $sujetClient;
    }

    public function getById(string $id): Sujet
    {
        if ($this->sujets === null) {
            $this->get();
        }

        return $this->sujets[$id];
    }

    private function get(): array
    {
        if ($this->sujets === null) {
            $this->sujets = $this->sujetClient->fetchData();
        }

        return $this->sujets;
    }
}
