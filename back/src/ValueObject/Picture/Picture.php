<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

class Picture
{
    private string $id;
    private string $path;

    public function __construct(
        string $id,
        string $path
    ) {
        $this->id = $id;
        $this->path = $path;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
