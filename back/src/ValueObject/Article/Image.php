<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Image implements BlockInterface
{
    private string $name;
    private ?string $url;
    private ?array $sujets;
    private ?string $source;

    public function __construct(
        string $name,
        ?string $url,
        ?array $sujets,
        ?string $source
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->sujets = $sujets;
        $this->source = $source;
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
        return new BlockType(BlockType::IMAGE_BLOCK);
    }
}
