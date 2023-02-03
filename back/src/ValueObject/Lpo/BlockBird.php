<?php
declare(strict_types=1);

namespace App\ValueObject\Lpo;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Picture\Picture;

class BlockBird implements BlockInterface
{
    public function __construct(
        private readonly ImportedBird $bird,
        private readonly Picture $image
    ) {
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::BIRD);
    }

    public function getTitle(): string
    {
        return sprintf('Présentation de %s', $this->bird->getFullName());
    }

    /**
     * @return ImportedBird
     */
    public function getContent()
    {
        return $this->bird;
    }

    public function getImage(): Picture
    {
        return $this->image;
    }
}
