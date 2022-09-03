<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Directory;
use App\ValueObject\Picture\Picture;
use Symfony\Component\Finder\Finder;

class ImageInPathLister
{
    private const ALLOWED_EXTENSIONS = ['*.jpg', '*.jpeg'];

    private string $pathPictures;

    public function __construct(string $pathPictures)
    {
        $this->pathPictures = $pathPictures;
    }

    public function getPicturesFromDirectory(string $subDirectory): Directory
    {
        $absolutePath = sprintf('%s%s', $this->pathPictures, $subDirectory);

        $finder = new Finder();
        $images = $finder->files()
            ->in($absolutePath)
            ->name(self::ALLOWED_EXTENSIONS)
        ;

        $pictures = [];
        foreach ($images as $image) {
            $pictures[] = new Picture(
                base64_encode($image->getRealPath()),
                $image->getRealPath()
            );
        }

        return new Directory($absolutePath, $pictures);
    }
}
