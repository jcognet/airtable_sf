<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

class Picture
{
    public function __construct(private readonly string $id, private readonly string $path) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
