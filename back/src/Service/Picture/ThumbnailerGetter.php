<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Enum\Picture\Format;
use App\Exception\Picture\UnknownThumbnailerException;

class ThumbnailerGetter
{
    public function __construct(
        private readonly ThumbnailerNameGetter $thumbnailerNameGetter,
        private readonly ThumbnailerGenerator $thumbnailerGenerator
    ) {
    }

    public function get(
        string $sourceImage,
        Format $format = null
    ): string {
        $thumbnailName = $this->thumbnailerNameGetter->get($sourceImage, $format);

        if (file_exists($thumbnailName)) {
            return $thumbnailName;
        }

        $this->thumbnailerGenerator->generate($sourceImage, $format);

        if (file_exists($thumbnailName)) {
            return $thumbnailName;
        }

        throw new UnknownThumbnailerException($thumbnailName);
    }
}
