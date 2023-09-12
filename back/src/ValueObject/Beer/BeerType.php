<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

class BeerType
{
    public function __construct(private readonly string $id, private readonly string $label) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
