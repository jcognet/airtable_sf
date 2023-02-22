<?php
declare(strict_types=1);

namespace App\ValueObject\Inr;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class InrToolList extends AbstractBlock
{
    /**
     * @param InrTool[] $inrTools
     */
    public function __construct(
        private readonly string $title,
        private readonly array $inrTools
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->inrTools;
    }

    public function getType(): BlockType
    {
        return BlockType::INR_TOOLS;
    }
}
