<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

class Directory
{
    private string $path;
    private array $pictures;

    public function __construct(
        string $path,
        array $images
    )
    {
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
}
