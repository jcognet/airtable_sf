<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Image extends AbstractBlock
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $url,
        private readonly ?array $sujets,
        private readonly ?string $source)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getSujets(): ?array
    {
        return $this->sujets;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getTitle(): string
    {
        return $this->getName();
    }

    public function getContent(): string
    {
        return $this->getUrl();
    }

    public function getType(): BlockType
    {
        return BlockType::IMAGE_BLOCK;
    }
}
