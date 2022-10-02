<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class GoodPracticesList implements BlockInterface
{
    /**
     * @param GoodPractice[] $goodPractices
     */
    public function __construct(private readonly string $title, private readonly array $goodPractices)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->goodPractices;
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::GOOD_PRACTICE_ORGANIZATION_BLOCK);
    }
}
