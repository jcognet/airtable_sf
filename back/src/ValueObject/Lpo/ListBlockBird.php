<?php
declare(strict_types=1);

namespace App\ValueObject\Lpo;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ListBlockBird extends AbstractBlock
{
    /**
     * @param BlockBird[] $birds
     */
    public function __construct(
        private readonly array $birds,
    ) {}

    public function getType(): BlockType
    {
        return BlockType::LIST_BIRD;
    }

    public function getTitle(): string
    {
        return 'Oiseaux en BDD';
    }

    /**
     * @return BlockBird[]
     */
    public function getContent()
    {
        return $this->birds;
    }
}
