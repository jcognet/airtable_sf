<?php
declare(strict_types=1);

namespace App\Service\Repository\Article;

use App\Service\AirTable\Article\SujetClient;
use App\ValueObject\Article\Sujet;

class SujetRepository
{
    private ?array $sujets = null;

    public function __construct(private readonly SujetClient $sujetClient)
    {
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
            $this->sujets = $this->sujetClient->findAll();
        }

        return $this->sujets;
    }
}
