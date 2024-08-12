<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

class Criteria
{
    public function __construct(
        private readonly string $id,
        private readonly string $critere,
        private readonly string $thematique,
        private readonly string $objectif,
        private readonly string $miseEnOeuvre,
        private readonly string $controle,
        private readonly string $hardship,
        private readonly ?string $priority,
        private readonly string $application,
        private readonly array $jobs,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getCritere(): string
    {
        return $this->critere;
    }

    public function getThematique(): string
    {
        return $this->thematique;
    }

    public function getObjectif(): string
    {
        return $this->objectif;
    }

    public function getMiseEnOeuvre(): string
    {
        return $this->miseEnOeuvre;
    }

    public function getControle(): string
    {
        return $this->controle;
    }

    public function getHardship(): string
    {
        return $this->hardship;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function getApplication(): string
    {
        return $this->application;
    }

    public function getJobs(): array
    {
        return $this->jobs;
    }
}
