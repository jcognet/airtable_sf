<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

class Weather
{
    public function __construct(private readonly int $id, public string $label) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
