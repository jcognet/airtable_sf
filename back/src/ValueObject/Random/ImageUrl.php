<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ImageUrl implements BlockInterface
{
    public function __construct(private readonly string $title, private readonly string $url)
    {
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
        return new BlockType(BlockType::IMAGE_URL_BLOCK);
    }
}
