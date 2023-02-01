<?php
declare(strict_types=1);

namespace App\ValueObject\Lpo;

class ImportedBird
{
    public function __construct(
        private readonly int $lpoId,
        private readonly string $name,
        private ?string $pdfUrl = null,
        private ?string $savedPath = null
    ) {
    }

    public function getLpoId(): int
    {
        return $this->lpoId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPdfUrl(): ?string
    {
        return $this->pdfUrl;
    }

    public function setPdfUrl(?string $pdfUrl): void
    {
        $this->pdfUrl = $pdfUrl;
    }

    public function getSavedPath(): ?string
    {
        return $this->savedPath;
    }

    public function setSavedPath(?string $savedPath): void
    {
        $this->savedPath = $savedPath;
    }
}
