<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

class GoodPractice
{
    private string $id;
    private string $priority;
    private string $difficulty;
    private array $indicators;
    private string $url;
    private string $title;

    public function __construct(
        string $id,
        string $priority,
        string $difficulty,
        array $indicators,
        string $url,
        string $title
    ) {
        $this->id = $id;
        $this->priority = $priority;
        $this->difficulty = $difficulty;
        $this->indicators = $indicators;
        $this->url = $url;
        $this->title = $title;
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
