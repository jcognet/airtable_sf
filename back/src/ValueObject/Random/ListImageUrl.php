<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ListImageUrl extends AbstractBlock
{
    /**
     * @param ImageUrl[] $listImages
     */
    public function __construct(
        private readonly string $title,
        private readonly array $listImages
    ) {
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
        return BlockType::IMAGE_LIST_URL_BLOCK;
    }
}
