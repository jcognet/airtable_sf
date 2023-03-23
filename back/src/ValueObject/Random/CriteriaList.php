<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class CriteriaList extends AbstractBlock
{
    /**
     * @param Criteria[] $criterias
     */
    public function __construct(
        private readonly string $title,
        private readonly array $criterias
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->criterias;
    }

    public function getType(): BlockType
    {
        return BlockType::RGESN_BLOCK;
    }
}
