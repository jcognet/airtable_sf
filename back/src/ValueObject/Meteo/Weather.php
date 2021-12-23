<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

class Weather
{
    public string $label;
    private int $id;

    public function __construct(int $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
