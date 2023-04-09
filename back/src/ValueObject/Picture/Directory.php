<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Directory extends AbstractBlock
{
    public function __construct(
        private readonly string $path,
        private array $pictures
    ) {
        usort($this->pictures, fn (Picture $a, Picture $b) => $a->getPath() <=> $b->getPath());
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
