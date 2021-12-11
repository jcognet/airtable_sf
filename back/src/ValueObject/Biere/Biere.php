<?php
declare(strict_types=1);

namespace App\ValueObject\Biere;

use App\ValueObject\BlockInterface;
use Carbon\Carbon;

class Biere implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'biere';

    private ?string $title;
    private ?string $avis;
    private ?Brasserie $brasserie;
    private ?int $note;
    private ?int $ibu;
    private ?string $photo;
    private Carbon $dateTest;
    private ?BiereType $biereType;
    private ?float $alcolholDegree;

    public function __construct(
        string $title,
        ?string $avis,
        ?Brasserie $brasserie,
        ?int $note,
        ?int $ibu,
        ?string $photo,
        Carbon $dateTest,
        ?BiereType $biereType,
        ?float $alcolholDegree
    ) {
        $this->title = $title;
        $this->avis = $avis;
        $this->brasserie = $brasserie;
        $this->note = $note;
        $this->ibu = $ibu;
        $this->photo = $photo;
        $this->dateTest = $dateTest;
        $this->biereType = $biereType;
        $this->alcolholDegree = $alcolholDegree;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->title;
    }

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function getBrasserie(): ?Brasserie
    {
        return $this->brasserie;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function getIbu(): ?int
    {
        return $this->ibu;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function getDateTest(): Carbon
    {
        return $this->dateTest;
    }

    public function getBiereType(): ?BiereType
    {
        return $this->biereType;
    }

    public function getAlcolholDegree(): ?float
    {
        return $this->alcolholDegree;
    }
}
