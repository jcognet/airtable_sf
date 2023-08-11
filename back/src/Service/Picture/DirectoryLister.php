<?php
declare(strict_types=1);

namespace App\Service\Picture;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DirectoryLister
{
    public function __construct(private readonly string $picturePath)
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
            ->in($this->picturePath)
            ->exclude('thumbnail')
        ;

        $directories = [];
        foreach ($directoryFinder as $directory) {
            $directories[] = $directory;
        }

        if (count($directories) === 0) {
            return null;
        }
        usort($directories, fn (SplFileInfo $a, SplFileInfo $b) => $a->getRelativePathname() <=> $b->getRelativePathname());

        return $directories;
    }
}
