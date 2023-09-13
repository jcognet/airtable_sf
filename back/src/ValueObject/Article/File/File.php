<?php
declare(strict_types=1);

namespace App\ValueObject\Article\File;

use Symfony\Component\Serializer\Annotation\Ignore;

class File
{
    private ?string $filePath = null;
    private ?string $airtableTmpFileUrl = null;
    private ?string $airtableTmpFileName = null;
    private ?string $fileUrl = null;

    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $url,
        private readonly string $airTableUrl
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    #[Ignore]
    public function getAirtableTmpFileUrl(): string
    {
        return $this->airtableTmpFileUrl;
    }

    public function setAirtableTmpFileUrl(?string $airtableTmpFileUrl): void
    {
        $this->airtableTmpFileUrl = $airtableTmpFileUrl;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getAirTableUrl(): string
    {
        return $this->airTableUrl;
    }

    #[Ignore]
    public function getAirtableTmpFileName(): ?string
    {
        return $this->airtableTmpFileName;
    }

    public function setAirtableTmpFileName(?string $airtableTmpFileName): void
    {
        $this->airtableTmpFileName = $airtableTmpFileName;
    }

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(?string $fileUrl): void
    {
        $this->fileUrl = $fileUrl;
    }
}
