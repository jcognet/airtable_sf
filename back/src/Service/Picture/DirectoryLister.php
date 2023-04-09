<?php
declare(strict_types=1);

namespace App\Service\Picture;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DirectoryLister
{
    public function __construct(private readonly string $pathPictures)
    {
    }

    /**
     * @return \SplFileInfo[]|null
     */
    public function list(): ?array
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
            if (substr_count((string) $directory->getRelativePathName(), \DIRECTORY_SEPARATOR) >= 1) {
                $directories[] = $directory;
            }
        }

        if (count($directories) === 0) {
            return null;
        }
        usort($directories, fn (SplFileInfo $a, SplFileInfo $b) => $a->getRelativePathname() <=> $b->getRelativePathname());

        return $directories;
    }
}
