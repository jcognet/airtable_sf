<?php
declare(strict_types=1);

namespace App\ValueObject\ToDo;

use Carbon\Carbon;

class Item
{
    public function __construct(
        private readonly string $id,
        private readonly Carbon $createdAt,
        private readonly ?string $label,
        private readonly ?string $notes,
        private readonly ?string $etat,
        private readonly ?Carbon $dueAt,
        private readonly ?string $category,
        private readonly bool $isImportant,
        private readonly string $airTableUrl,
        private readonly ?int $complexity = null,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function getDueAt(): ?Carbon
    {
        return $this->dueAt;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function isImportant(): bool
    {
        return $this->isImportant;
    }

    public function getAirTableUrl(): string
    {
        return $this->airTableUrl;
    }

    public function getComplexity(): ?int
    {
        return $this->complexity;
    }
}
