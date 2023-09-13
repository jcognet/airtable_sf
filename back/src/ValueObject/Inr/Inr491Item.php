<?php
declare(strict_types=1);

namespace App\ValueObject\Inr;

class Inr491Item
{
    public function __construct(
        private readonly ?string $title,
        private readonly ?string $url,
    ) {}

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
