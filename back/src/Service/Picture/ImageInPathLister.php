<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Directory;
use Symfony\Component\Finder\Finder;

class ImageInPathLister
{
    private const ALLOWED_EXTENSIONS = ['*.jpg', '*.jpeg'];

    public function __construct(
        private readonly PictureFactory $pictureFactory,
        private readonly string $picturePath
    ) {
    }

    public function getPicturesFromDirectory(string $subDirectory): Directory
    {
        $absolutePath = sprintf('%s%s', $this->picturePath, $subDirectory);

        $finder = new Finder();
        $images = $finder->files()
            ->in($absolutePath)
            ->name(self::ALLOWED_EXTENSIONS)
            ->exclude('thumbnail')
        ;

        $pictures = [];
        foreach ($images as $image) {
            $pictures[] = $this->pictureFactory->get(
                $image->getRealPath()
            );
        }

        return new Directory($absolutePath, $pictures);
    }
}
