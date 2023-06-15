<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class MeteoList extends AbstractBlock
{
    /**
     * @param MeteoItem[] $meteoItemLists
     */
    public function __construct(
        private readonly array $meteoItemLists
    ) {
    }

    public function getTitle(): string
    {
        $places = array_unique(
            array_map(
                fn ($meteoItem) => $meteoItem->getPlace()->getLabel(),
                $this->meteoItemLists
            )
        );

        return sprintf('Météo de %s.', implode(', ', $places));
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
}
