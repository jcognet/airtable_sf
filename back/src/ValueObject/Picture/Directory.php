<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Directory extends AbstractBlock
{
    private array $pictures = [];
    private array $subDirectories = [];

    public function __construct(
        private readonly string $path,
        private readonly string $downloadLink,
        private readonly string $relativePath,
        array $pictures,
        array $subDirectories
    ) {
        usort($pictures, static fn (Picture $a, Picture $b) => $a->getPath() <=> $b->getPath());
        $this->pictures = $pictures;
        usort($subDirectories, static fn (Directory $a, Directory $b) => $a->getTitle() <=> $b->getTitle());
        $this->subDirectories = $subDirectories;
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

    public function getDownloadLink(): string
    {
        return $this->downloadLink;
    }

    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    public function getSubDirectories(): array
    {
        return $this->subDirectories;
    }
}
