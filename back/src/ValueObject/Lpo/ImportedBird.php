<?php
declare(strict_types=1);

namespace App\ValueObject\Lpo;

class ImportedBird
{
    public function __construct(
        private readonly int $lpoId,
        private readonly string $name,
        private ?string $lpoUrl = null,
        private ?string $fullName = null,
        private ?string $pdfUrl = null,
        private ?string $savedPdfPath = null,
        private ?string $savedImgPath = null,
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

    public function getSavedPdfPath(): ?string
    {
        return $this->savedPdfPath;
    }

    public function setSavedPdfPath(?string $savedPdfPath): void
    {
        $this->savedPdfPath = $savedPdfPath;
    }

    public function getSavedImgPath(): ?string
    {
        return $this->savedImgPath;
    }

    public function setSavedImgPath(?string $savedImgPath): void
    {
        $this->savedImgPath = $savedImgPath;
    }

    public function getLpoUrl(): ?string
    {
        return $this->lpoUrl;
    }

    public function setLpoUrl(?string $lpoUrl): void
    {
        $this->lpoUrl = $lpoUrl;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }
}
