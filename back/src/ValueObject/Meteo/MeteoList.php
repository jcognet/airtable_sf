<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class MeteoList extends AbstractBlock
{
    private ?Place $place = null;

    /**
     * @param MeteoItem[] $meteoItemLists
     */
    public function __construct(
        private readonly array $meteoItemLists,
        private readonly string $latitude,
        private readonly string $longitude
    ) {
    }

    public function getTitle(): string
    {
        return sprintf('Météo de %s', $this->place->getLabel());
    }

    public function getContent()
    {
        return $this->getMeteoItemLists();
    }

    public function getType(): BlockType
    {
        return BlockType::LIST_METEO_BLOCK;
    }

    public function getMeteoItemLists(): array
    {
        return $this->meteoItemLists;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setPlace(?Place $place): void
    {
        $this->place = $place;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }
}
