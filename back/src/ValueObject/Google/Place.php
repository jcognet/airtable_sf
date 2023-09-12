<?php
declare(strict_types=1);

namespace App\ValueObject\Google;

class Place
{
    public function __construct(
        private readonly string $name,
        private readonly string $address,
        private readonly ?float $rating,
        private readonly ?int $ratingUserTotal,
        private readonly ?string $openingHours,
        private readonly ?string $description,
        private readonly ?string $phoneNumber,
        private readonly ?string $googleUrl,
        private readonly ?string $url,
    ) {}

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function getRatingUserTotal(): ?int
    {
        return $this->ratingUserTotal;
    }

    public function getOpeningHours(): ?string
    {
        return $this->openingHours;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getGoogleUrl(): ?string
    {
        return $this->googleUrl;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
