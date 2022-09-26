<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Exception\Picture\UnknownThumbnailerException;

class ThumbnailerGetter
{
    private ThumbnailerNameGetter $thumbnailerNameGetter;
    private ThumbnailerGenerator $thumbnailerGenerator;

    public function __construct(
        ThumbnailerNameGetter $thumbnailerNameGetter,
        ThumbnailerGenerator $thumbnailerGenerator
    ) {
        $this->thumbnailerNameGetter = $thumbnailerNameGetter;
        $this->thumbnailerGenerator = $thumbnailerGenerator;
    }

    public function get(string $sourceImage): string
    {
        $thumbnailName = $this->thumbnailerNameGetter->get($sourceImage);
        if (file_exists($thumbnailName)) {
            return $thumbnailName;
        }

        $this->thumbnailerGenerator->generate($sourceImage);

        if (file_exists($thumbnailName)) {
            return $thumbnailName;
        }

        throw new UnknownThumbnailerException($thumbnailName);
    }
}
