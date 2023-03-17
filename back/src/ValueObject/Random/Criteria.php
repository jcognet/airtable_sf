<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

class Criteria
{
    public function __construct(
        private readonly string $id,
        private readonly string $url,
        private readonly string $critere,
        private readonly string $thematique,
        private readonly string $objectif,
        private readonly string $miseEnOeuvre,
        private readonly string $controle
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getThematique(): string
    {
        return $this->thematique;
    }

    public function getCritere(): string
    {
        return $this->critere;
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
}
