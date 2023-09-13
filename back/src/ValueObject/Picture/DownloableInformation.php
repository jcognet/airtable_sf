<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

class DownloableInformation
{
    public function __construct(
        private readonly ?int $nbFiles,
        private readonly ?float $size,
        private readonly bool $isDownloadable
    ) {}

    public function getNbFiles(): ?int
    {
        return $this->nbFiles;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function isDownloadable(): bool
    {
        return $this->isDownloadable;
    }
}
