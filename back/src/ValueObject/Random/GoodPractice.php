<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

class GoodPractice
{
    public function __construct(
        private readonly string $id,
        private readonly string $priority,
        private readonly string $difficulty,
        private readonly array $indicators,
        private readonly string $url,
        private readonly string $title
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getDifficulty(): string
    {
        return $this->difficulty;
    }

    public function getIndicators(): array
    {
        return $this->indicators;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
