<?php
declare(strict_types=1);

namespace App\ValueObject\Beer;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class BeerList implements BlockInterface
{
    private ?string $title;
    /**
     * @var Beer[]
     */
    private array $beers;

    public function __construct(
        string $title,
        array $beers
    ) {
        $this->title = $title;
        $this->beers = $beers;
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
        return new BlockType(BlockType::LIST_BEER__BLOCK);
    }
}
