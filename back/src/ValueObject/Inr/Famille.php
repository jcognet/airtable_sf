<?php
declare(strict_types=1);

namespace App\ValueObject\Inr;

class Famille
{
    private ?Inr491Recommandation $randomContent = null;

    public function __construct(
        private readonly ?string $title,
        private readonly ?string $description,
        private readonly ?string $recommandations,
        private readonly ?string $criteres,
        private readonly string $url
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getRecommandations(): ?string
    {
        return $this->recommandations;
    }

    public function getCriteres(): ?string
    {
        return $this->criteres;
    }

    public function getRandomContent(): Inr491Recommandation
    {
        return $this->randomContent;
    }

    public function addRandomContent(Inr491Recommandation $item): void
    {
        $this->randomContent = $item;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
