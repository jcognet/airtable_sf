<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Exception\Picture\UnknownTypeFileException;
use Symfony\Component\Filesystem\Filesystem;

class ThumbnailerGenerator
{
    private ThumbnailerNameGetter $thumbnailerNameGetter;
    private array $thumbnailDefaults;

    public function __construct(
        ThumbnailerNameGetter $thumbnailerNameGetter,
        array $thumbnailDefaults
    ) {
        // Adapted from http://www.inanzzz.com/index.php/post/0m8s/image-upload-create-thumbnail-center-and-add-padding-in-symfony
        $this->thumbnailerNameGetter = $thumbnailerNameGetter;
        $this->thumbnailDefaults = $thumbnailDefaults;
    }

    public function generate(string $sourceImage): void
    {
        [$sourceWidth, $sourceHeight, $sourceType] = getimagesize($sourceImage);

        switch ($sourceType) {
            case IMAGETYPE_JPEG:
                $sourceGdImage = imagecreatefromjpeg($sourceImage);
                break;
            default:
                throw new UnknownTypeFileException($sourceType, ['jpg']);
        }

        if ($sourceGdImage === false) {
            throw new UnknownTypeFileException($sourceType, ['jpg']);
        }

        $sourceAspectRatio = ($sourceWidth / $sourceHeight);
        $thumbnailAspectRatio = ($this->thumbnailDefaults['width'] / $this->thumbnailDefaults['height']);

        if ($sourceWidth <= $this->thumbnailDefaults['width'] && $sourceHeight <= $this->thumbnailDefaults['height']) {
            $thumbnailWidth = $sourceWidth;
            $thumbnailHeight = $sourceHeight;
        } elseif ($thumbnailAspectRatio > $sourceAspectRatio) {
            $thumbnailWidth = (int) ($this->thumbnailDefaults['height'] * $sourceAspectRatio);
            $thumbnailHeight = $this->thumbnailDefaults['height'];
        } else {
            $thumbnailWidth = $this->thumbnailDefaults['width'];
            $thumbnailHeight = (int) ($this->thumbnailDefaults['width'] / $sourceAspectRatio);
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
        $thumbnailName = $this->thumbnailerNameGetter->get($sourceImage);
        $fs->mkdir($this->thumbnailerNameGetter->getDirectory($sourceImage));

        imagejpeg($thumbnailGdImage, $thumbnailName, 90);

        imagedestroy($sourceGdImage);
        imagedestroy($thumbnailGdImage);
    }
}
