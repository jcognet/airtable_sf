<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Directory;
use Symfony\Component\Finder\Finder;

class ImageInPathLister
{
    private const ALLOWED_EXTENSIONS = ['*.jpg', '*.jpeg'];

    private string $pathPictures;
    private ImageFactory $imageFactory;

    public function __construct(
        ImageFactory $imageFactory,
        string $pathPictures
    ) {
        $this->pathPictures = $pathPictures;
        $this->imageFactory = $imageFactory;
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
            $pictures[] = $this->imageFactory->get(
                $image->getRealPath()
            );
        }

        return new Directory($absolutePath, $pictures);
    }
}
