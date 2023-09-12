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
        private readonly ?string $sprint,
        private readonly bool $isImportant
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

    public function getSprint(): ?string
    {
        return $this->sprint;
    }

    public function isImportant(): bool
    {
        return $this->isImportant;
    }
}
