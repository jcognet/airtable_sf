<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Directory;
use Symfony\Component\Finder\Finder;

class ImageInPathLister
{
    private const ALLOWED_EXTENSIONS = ['*.jpg', '*.jpeg'];

    public function __construct(
        private readonly PictureFactory $pictureFactory,
        private readonly string $picturePath,
        private readonly EncoderDecoder $encoderDecoder
    ) {
    }

    public function getPicturesFromDirectory(string $subDirectoryPath, bool $withSubDirectory = true): Directory
    {
        $absolutePath = realpath(sprintf('%s%s', $this->picturePath, $subDirectoryPath));

        $finder = new Finder();
        $images = $finder->files()
            ->in($absolutePath)
            ->name(self::ALLOWED_EXTENSIONS)
            ->exclude('thumbnail')
            ->sortByName()
        ;

        $pictures = [];
        foreach ($images as $image) {
            $pictures[] = $this->pictureFactory->get(
                $image->getRealPath()
            );
        }

        $subDirectories = [];
        if ($withSubDirectory) {
            $finderSubDirectory = new Finder();
            $subDirectoriesResult = $finderSubDirectory->directories()
                ->in($absolutePath)
                ->exclude('thumbnail')
                ->sortByName()
                ->depth(0)
            ;

            foreach ($subDirectoriesResult as $subDirectory) {
                $subDirectories[] = $this->getPicturesFromDirectory(
                    sprintf(
                        '%s/%s',
                        $subDirectoryPath,
                        $subDirectory->getRelativePathname()
                    ),
                    false
                );
            }
        }

        return new Directory(
            path: $absolutePath,
            downloadLink: $this->encoderDecoder->encode(
                ZipAllPictureDirectory::getFileName($absolutePath)
            ),
            relativePath: $subDirectoryPath,
            pictures: $pictures,
            subDirectories: $subDirectories
        );
    }
}
