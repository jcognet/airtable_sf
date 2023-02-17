<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class BeerList implements BlockInterface
{
    /**
     * @param Beer[] $beers
     */
    public function __construct(private readonly ?string $title, private readonly array $beers)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->beers;
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::LIST_BEER_BLOCK);
    }
}
