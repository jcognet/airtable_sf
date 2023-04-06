<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Picture;

class RandomPictorySelector
{
    public function __construct(private readonly ImageInPathLister $imageInPathLister)
    {
    }

    public function select(string $directory): Picture
    {
        $directory = $this->imageInPathLister->getPicturesFromDirectory($directory);
        $pictures = $directory->getPictures();

        return $pictures[array_rand($pictures)];
    }
}
