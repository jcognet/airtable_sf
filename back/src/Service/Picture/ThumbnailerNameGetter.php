<?php
declare(strict_types=1);

namespace App\Service\Picture;

class ThumbnailerNameGetter
{
    private const SUB_DIR_THUMBNAIL = 'thumbnail';

    public function get(string $sourceImage): string
    {
        return sprintf(
            '%s/%s/%s',
            dirname($sourceImage),
            self::SUB_DIR_THUMBNAIL,
            basename($sourceImage)
        );
    }

    public function getDirectory(string $sourceImage): string
    {
        return sprintf(
            '%s/%s',
            dirname($sourceImage),
            self::SUB_DIR_THUMBNAIL
        );
    }
}
