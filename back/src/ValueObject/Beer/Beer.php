<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

use App\Exception\MethodNotUsableException;
use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Picture\CachedImage;
use Carbon\Carbon;
use Symfony\Component\Serializer\Annotation\Ignore;

class Beer extends AbstractBlock
{
    public function __construct(
        private readonly ?string $title,
        private readonly ?string $avis,
        private readonly ?Brewery $brasserie,
        private readonly ?int $note,
        private readonly ?int $ibu,
        private readonly ?CachedImage $photo,
        private readonly Carbon $dateTest,
        private readonly ?BeerType $beerType,
        private readonly ?float $alcolholDegree,
        private readonly string $url
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->title;
    }

    #[Ignore]
    public function getType(): BlockType
    {
        throw new MethodNotUsableException(
            sprintf('Method getType from %s it not callable.', self::class)
        );
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

    public function getPhoto(): ?CachedImage
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
