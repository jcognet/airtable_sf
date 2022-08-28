<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Concept implements BlockInterface
{
    private string $name;
    private string $text;

    public function __construct(
        string $name,
        string $text
    ) {
        $this->name = $name;
        $this->text = $text;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTitle(): string
    {
        return $this->getName();
    }

    public function getContent()
    {
        return $this->getText();
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::CONCEPT);
    }
}
