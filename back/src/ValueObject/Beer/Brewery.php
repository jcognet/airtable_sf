<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

class Brewery
{
    public function __construct(
        private readonly string $id,
        private readonly ?string $label,
        private readonly ?string $url
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
