<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class CriteriaList implements BlockInterface
{
    private string $title;
    /**
     * @var Criteria[]
     */
    private array $criterias;

    public function __construct(string $title, array $criterias)
    {
        $this->title = $title;
        $this->criterias = $criterias;
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
        return new BlockType(BlockType::RGSEN_BLOCK);
    }
}
