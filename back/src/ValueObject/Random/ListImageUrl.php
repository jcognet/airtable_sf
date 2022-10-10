<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ListImageUrl implements BlockInterface
{
    /**
     * @param ImageUrl[] $listImages
     */
    public function __construct(private readonly string $title, private readonly array $listImages)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->listImages;
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::IMAGE_LIST_URL_BLOCK);
    }
}