<?php
declare(strict_types=1);

namespace App\Service\Block\Picture;

use App\Service\Block\BlockManagerInterface;
use App\Service\Picture\ImageInPathLister;
use App\Service\Picture\RandomDirectorySelector;
use App\ValueObject\BlockInterface;

class PictureManager implements BlockManagerInterface
{
    public function __construct(
        private readonly ImageInPathLister $imageInPathLister,
        private readonly RandomDirectorySelector $randomDirectorySelector
    ) {}

    public function getContent(): ?BlockInterface
    {
        $dir = $this->randomDirectorySelector->getRandomDirectory();

        if ($dir === null) {
            return null;
        }

        return $this->imageInPathLister->getPicturesFromDirectory(
            $dir
        );
    }
}
