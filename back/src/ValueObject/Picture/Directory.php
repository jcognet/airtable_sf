<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Directory implements BlockInterface
{
    private string $path;
    private array $pictures;

    public function __construct(
        string $path,
        array $images
    ) {
        $this->path = $path;
        $this->pictures = $images;
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
        return new BlockType(BlockType::IMAGE_LIST_PICTURES);
    }
}
