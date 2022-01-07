<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

class Criteria
{
    private string $id;
    private string $url;
    private string $critere;
    private string $objectif;
    private string $miseEnOeuvre;
    private string $controle;
    private string $thematique;

    public function __construct(
        string $id,
        string $url,
        string $critere,
        string $thematique,
        string $objectif,
        string $miseEnOeuvre,
        string $controle
    )
    {
        $this->id = $id;
        $this->url = $url;
        $this->critere = $critere;
        $this->objectif = $objectif;
        $this->miseEnOeuvre = $miseEnOeuvre;
        $this->controle = $controle;
        $this->thematique = $thematique;
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
