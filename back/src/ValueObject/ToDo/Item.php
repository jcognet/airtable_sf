<?php
declare(strict_types=1);

namespace App\ValueObject\ToDo;

use Carbon\Carbon;

class Item
{
    private string $id;
    private Carbon $createdAt;
    private ?string $label;
    private ?string $notes;
    private ?string $etat;
    private ?Carbon $dueAt;
    private ?string $category;
    private ?string $sprint;
    private bool $isImportant;

    public function __construct(
        string $id,
        Carbon $createdAt,
        ?string $label,
        ?string $notes,
        ?string $etat,
        ?Carbon $dueAt,
        ?string $category,
        ?string $sprint,
        bool $isImportant
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->label = $label;
        $this->notes = $notes;
        $this->etat = $etat;
        $this->dueAt = $dueAt;
        $this->category = $category;
        $this->sprint = $sprint;
        $this->isImportant = $isImportant;
    }

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
