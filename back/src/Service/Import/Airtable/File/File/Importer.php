<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\File\File;

use App\Service\FileDownloader;
use App\Service\Import\Airtable\AbstractImporter;
use App\ValueObject\Article\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Importer extends AbstractImporter
{
    private ?FileDownloader $fileDownloader = null;
    private ?SluggerInterface $slugger = null;
    private ?string $filePath = null;

    #[Required]
    public function setFileDownloader(FileDownloader $fileDownloader): void
    {
        $this->fileDownloader = $fileDownloader;
    }

    #[Required]
    public function setSlugger(SluggerInterface $slugger): void
    {
        $this->slugger = $slugger;
    }

    #[Required]
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    protected function preSave(array $data): array
    {
        /**
         * @var File $file
         */
        foreach ($data as $file) {
            $slug = sprintf(
                '%s_%s.%s',
                $this->slugger->slug(
                    strtolower($file->getTitle())
                ),
                $file->getId(),
                pathinfo($file->getAirtableTmpFileName())['extension']
            );

            $localPathPicture = sprintf(
                '%s/%s',
                $this->filePath,
                $slug
            );

            $this->fileDownloader->download(
                $file->getAirtableTmpFileUrl(),
                $localPathPicture
            );

            $file->setFilePath($localPathPicture);
        }

        return $data;
    }
}
