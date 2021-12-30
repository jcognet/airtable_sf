<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ImageUrl implements BlockInterface
{
    private string $title;
    private string $url;

    public function __construct(string $title, string $url)
    {
        $this->title = $title;
        $this->url = $url;
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
