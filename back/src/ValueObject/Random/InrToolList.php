<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class InrToolList implements BlockInterface
{
    private string $title;
    /**
     * @var InrTool[]
     */
    private array $inrTools;

    public function __construct(string $title, array $inrTools)
    {
        $this->title = $title;
        $this->inrTools = $inrTools;
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
        return new BlockType(BlockType::INR_TOOLS);
    }
}
