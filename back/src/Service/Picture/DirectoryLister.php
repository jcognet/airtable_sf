<?php
declare(strict_types=1);

namespace App\Service\Picture;

use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DirectoryLister
{
    public function __construct(private readonly string $picturePath) {}

    /**
     * @return \SplFileInfo[]|null
     */
    public function list(): ?array
    {
        $finder = new Finder();

        try {
            $directoryFinder = $finder
                ->directories()
                ->in($this->picturePath)
                ->exclude('thumbnail')
            ;
        } catch (DirectoryNotFoundException) {
            return null;
        }

        $directories = [];
        foreach ($directoryFinder as $directory) {
            $directories[] = $directory;
        }

        if (count($directories) === 0) {
            return null;
        }
        usort($directories, static fn (SplFileInfo $a, SplFileInfo $b) => $a->getRelativePathname() <=> $b->getRelativePathname());

        return $directories;
    }
}
