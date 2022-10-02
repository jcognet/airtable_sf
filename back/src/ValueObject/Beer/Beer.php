<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

use App\Exception\MethodNotUsableException;
use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;

class Beer implements BlockInterface
{
    public function __construct(private readonly ?string $title, private readonly ?string $avis, private readonly ?Brewery $brasserie, private readonly ?int $note, private readonly ?int $ibu, private readonly ?string $photo, private readonly Carbon $dateTest, private readonly ?BeerType $beerType, private readonly ?float $alcolholDegree, private readonly string $url)
    {
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
