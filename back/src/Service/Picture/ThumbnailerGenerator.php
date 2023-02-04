<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Enum\Picture\Format;
use App\Exception\Picture\UnknownTypeFileException;
use Symfony\Component\Filesystem\Filesystem;

class ThumbnailerGenerator
{
    public function __construct(
        private readonly ThumbnailerNameGetter $thumbnailerNameGetter,
        private readonly array $thumbnailList
    ) {
    }

    public function generate(
        string $sourceImage,
        Format $format
    ): void {
        [$sourceWidth, $sourceHeight, $sourceType] = getimagesize($sourceImage);

        $sourceGdImage = match ($sourceType) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourceImage),
            default => throw new UnknownTypeFileException($sourceType, ['jpg']),
        };

        if ($sourceGdImage === false) {
            throw new UnknownTypeFileException($sourceType, ['jpg']);
        }

        $thumbnailConfiguration = $this->thumbnailList[$format->value];

        $sourceAspectRatio = ($sourceWidth / $sourceHeight);
        $thumbnailAspectRatio = ($thumbnailConfiguration['width'] / $thumbnailConfiguration['height']);

        if ($sourceWidth <= $thumbnailConfiguration['width'] && $sourceHeight <= $thumbnailConfiguration['height']) {
            $thumbnailWidth = $sourceWidth;
            $thumbnailHeight = $sourceHeight;
        } elseif ($thumbnailAspectRatio > $sourceAspectRatio) {
            $thumbnailWidth = (int) ($thumbnailConfiguration['height'] * $sourceAspectRatio);
            $thumbnailHeight = $thumbnailConfiguration['height'];
        } else {
            $thumbnailWidth = $thumbnailConfiguration['width'];
            $thumbnailHeight = (int) ($thumbnailConfiguration['width'] / $sourceAspectRatio);
        }

        $thumbnailGdImage = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

        // Keep the transparency
        imagecolortransparent($thumbnailGdImage, imagecolorallocatealpha($thumbnailGdImage, 0, 0, 0, 127));
        imagealphablending($thumbnailGdImage, false);
        imagesavealpha($thumbnailGdImage, true);

        imagecopyresampled(
            $thumbnailGdImage,
            $sourceGdImage,
            0,
            0,
            0,
            0,
            $thumbnailWidth,
            $thumbnailHeight,
            $sourceWidth,
            $sourceHeight
        );

        $fs = new Filesystem();
        $thumbnailName = $this->thumbnailerNameGetter->get($sourceImage, $format);
        $fs->mkdir($this->thumbnailerNameGetter->getDirectory($sourceImage));

        imagejpeg($thumbnailGdImage, $thumbnailName, 90);

        imagedestroy($sourceGdImage);
        imagedestroy($thumbnailGdImage);
    }
}
