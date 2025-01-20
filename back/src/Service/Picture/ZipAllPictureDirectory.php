<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Exception\Picture\DirectoryNotZippableException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\SplFileInfo;

class ZipAllPictureDirectory
{
    private const FILE_NAME = 'files.zip';
    private const NB_DIRECTORIES_TO_ZIP = 30;

    public function __construct(
        private readonly DirectoryLister $directoryLister,
        private readonly ImageInPathLister $imageInPathLister,
        private readonly LoggerInterface $logger
    ) {}

    public function zipAll(): void
    {
        $dirs = $this->directoryLister->list();

        if (!$dirs) {
            return;
        }

        foreach ($this->filterDirectories($dirs) as $directory) {
            $this->logger->debug(sprintf('Current directory: %s', $directory->getRealPath()));
            $zip = new \ZipArchive();
            $zipFileName = self::getFileName($directory->getRealPath());

            if ($zip->open($zipFileName, \ZipArchive::CREATE) !== true) {
                throw new DirectoryNotZippableException($directory->getRealPath());
            }

            $directoryWithPictures = $this->imageInPathLister->getPicturesFromDirectory($directory->getRelativePathName());

            foreach ($directoryWithPictures->getPictures() as $file) {
                $this->logger->debug(sprintf('Add %s to %s', $file->getPath(), $zipFileName));
                $zip->addFile($file->getPath(), basename($file->getPath()));
            }

            $this->logger->info(
                sprintf(
                    'Zip %s finished with %d files and status: %s.',
                    $zipFileName,
                    $zip->count(),
                    $zip->status
                )
            );

            $zip->close();
        }
    }

    public static function getFileName(string $absolutePath): string
    {
        return sprintf(
            '%s/%s',
            $absolutePath,
            self::FILE_NAME
        );
    }

    private function filterDirectories(array $directories): array
    {
        usort(
            $directories,
            static function (SplFileInfo $a, SplFileInfo $b) {
                $fileA = self::getFileName($a->getRealPath());
                $fileB = self::getFileName($b->getRealPath());

                if (file_exists($fileA) && file_exists($fileB)) {
                    return $a->getMTime() <=> $b->getMTime();
                }

                if (!file_exists($fileA) && !file_exists($fileB)) {
                    return $a->getMTime() <=> $b->getMTime();
                }

                if (!file_exists($fileA)) {
                    return -1;
                }

                return 1;
            }
        );

        return array_slice($directories, 0, self::NB_DIRECTORIES_TO_ZIP);
    }
}
