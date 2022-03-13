<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

use App\Exception\MethodNotUsableException;
use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;

class Beer implements BlockInterface
{
    private ?string $title;
    private ?string $avis;
    private ?Brewery $brasserie;
    private ?int $note;
    private ?int $ibu;
    private ?string $photo;
    private Carbon $dateTest;
    private ?BeerType $beerType;
    private ?float $alcolholDegree;
    private string $url;

    public function __construct(
        string $title,
        ?string $avis,
        ?Brewery $brasserie,
        ?int $note,
        ?int $ibu,
        ?string $photo,
        Carbon $dateTest,
        ?BeerType $beerType,
        ?float $alcolholDegree,
        string $url
    ) {
        $this->title = $title;
        $this->avis = $avis;
        $this->brasserie = $brasserie;
        $this->note = $note;
        $this->ibu = $ibu;
        $this->photo = $photo;
        $this->dateTest = $dateTest;
        $this->beerType = $beerType;
        $this->alcolholDegree = $alcolholDegree;
        $this->url = $url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->title;
    }

    public function getType(): BlockType
    {
        throw new MethodNotUsableException('Method getType from %s it not callable.', self::class);
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function getBrasserie(): ?Brewery
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

    public function getBeerType(): ?BeerType
    {
        return $this->beerType;
    }

    public function getAlcolholDegree(): ?float
    {
        return $this->alcolholDegree;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
