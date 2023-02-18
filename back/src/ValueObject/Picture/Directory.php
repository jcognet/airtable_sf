<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Directory implements BlockInterface
{
    public function __construct(private readonly string $path, private readonly array $pictures)
    {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return Picture[]
     */
    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function getTitle(): string
    {
        return 'Souvenirs, souvenirs';
    }

    public function getContent()
    {
        return $this->getPictures();
    }

    public function getType(): BlockType
    {
        return BlockType::IMAGE_LIST_PICTURES;
    }
}
