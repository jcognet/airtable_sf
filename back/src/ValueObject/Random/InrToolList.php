<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class InrToolList implements BlockInterface
{
    /**
     * @param InrTool[] $inrTools
     */
    public function __construct(private readonly string $title, private readonly array $inrTools)
    {
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
