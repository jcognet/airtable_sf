<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ImageUrl extends AbstractBlock
{
    public function __construct(
        private readonly string $title,
        private readonly string $url,
        private readonly ?int $width = null
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->url;
    }

    public function getType(): BlockType
    {
        return BlockType::IMAGE_URL_BLOCK;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }
}
