<?php
declare(strict_types=1);

namespace App\ValueObject\Inr;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class BlockFamille extends AbstractBlock
{
    public function __construct(
        private readonly Famille $famille
    ) {}

    public function getTitle(): string
    {
        return 'INR 491';
    }

    public function getContent()
    {
        return $this->famille;
    }

    public function getType(): BlockType
    {
        return BlockType::INR_491;
    }
}
