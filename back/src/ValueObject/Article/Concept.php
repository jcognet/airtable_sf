<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Concept implements BlockInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $text,
        private readonly array $linkedContents,
        private readonly string $airTableUrl
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return BlockInterface[]
     */
    public function getLinkedContents(): array
    {
        return $this->linkedContents;
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
        return BlockType::CONCEPT_BLOCK;
    }

    public function getAirTableUrl(): string
    {
        return $this->airTableUrl;
    }
}
