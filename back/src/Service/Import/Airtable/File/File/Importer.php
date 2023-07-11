<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\File\File;

use App\Service\FileDownloader;
use App\Service\Import\Airtable\AbstractImporter;
use App\Service\Picture\EncoderDecoder;
use App\ValueObject\Article\File\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Importer extends AbstractImporter
{
    private ?FileDownloader $fileDownloader = null;
    private ?SluggerInterface $slugger = null;
    private ?string $filePath = null;
    private ?EncoderDecoder $encoderDecoder = null;
    private ?UrlGeneratorInterface $router = null;

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

    #[Required]
    public function setEncoderDecoder(?EncoderDecoder $encoderDecoder): void
    {
        $this->encoderDecoder = $encoderDecoder;
    }

    #[Required]
    public function setRouter(?UrlGeneratorInterface $router): void
    {
        $this->router = $router;
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
            $localPath = sprintf(
                '%s%s',
                $this->filePath,
                $slug
            );
            $this->fileDownloader->download(
                $file->getAirtableTmpFileUrl(),
                $localPath
            );

            $file->setFilePath($localPath);
            // We generate the url here so that the app is quicker (one calculation when importing)
            $file->setFileUrl(
                $this->router->generate(
                    'file_download',
                    [
                        'pathFile' => $this->encoderDecoder->encode($localPath),
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            );
        }

        return $data;
    }
}
