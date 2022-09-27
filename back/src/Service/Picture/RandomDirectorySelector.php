<?php
declare(strict_types=1);

namespace App\Service\Picture;

use Symfony\Component\Finder\Finder;

class RandomDirectorySelector
{
    private string $pathPictures;

    public function __construct(
        string $pathPictures
    ) {
        $this->pathPictures = $pathPictures;
    }

    public function getRandomDirectory(): string
    {
        $finder = new Finder();
        $directoryFinder = $finder
            ->directories()
            ->in($this->pathPictures)
            ->exclude('thumbnail')
        ;

        $directories = [];
        foreach ($directoryFinder as $directory) {
            /** @var \SplFileInfo $directory */
            if (substr_count($directory->getRelativePathName(), \DIRECTORY_SEPARATOR) >= 1) {
                $directories[] = $directory;
            }
        }

        return $directories[array_rand($directories)]->getRelativePathName();
    }
}
