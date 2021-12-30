<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

class Brewery
{
    private string $id;
    private ?string $label;
    private ?string $url;

    public function __construct(string $id, ?string $label, ?string $url)
    {
        $this->id = $id;
        $this->label = $label;
        $this->url = $url;
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
