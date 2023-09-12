<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

class Place
{
    public function __construct(
        private readonly string $label,
        private readonly string $researchKey
    ) {}

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getResearchKey(): string
    {
        return $this->researchKey;
    }
}
