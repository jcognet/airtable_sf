<?php
declare(strict_types=1);

namespace App\Service\Block\Picture;

use App\Service\Block\BlockManagerInterface;
use App\Service\Picture\ImageInPathLister;
use App\Service\Picture\RandomDirectorySelector;
use App\ValueObject\BlockInterface;

class PictureManager implements BlockManagerInterface
{
    private ImageInPathLister $imageInPathLister;
    private RandomDirectorySelector $randomDirectorySelector;

    public function __construct(
        ImageInPathLister $imageInPathLister,
        RandomDirectorySelector $randomDirectorySelector
    )
    {
        $this->imageInPathLister = $imageInPathLister;
        $this->randomDirectorySelector = $randomDirectorySelector;
    }

    public function getContent(): ?BlockInterface
    {
        return $this->imageInPathLister->getPicturesFromDirectory(
            $this->randomDirectorySelector->getRandomDirectory()
        );
    }
}
