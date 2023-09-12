<?php
declare(strict_types=1);

namespace App\Service\Picture;

class RandomDirectorySelector
{
    public function __construct(
        private readonly DirectoryLister $directoryLister
    ) {}

    public function getRandomDirectory(): ?string
    {
        $directories = $this->directoryLister->list();

        if ($directories === null) {
            return null;
        }

        return $directories[array_rand($directories)]->getRelativePathName();
    }
}
