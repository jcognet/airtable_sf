<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\Enum\Picture\Format;

class ThumbnailerNameGetter
{
    private const SUB_DIR_THUMBNAIL = 'thumbnail';

    public function get(
        string $sourceImage,
        Format $format
    ): string {
        $prefix = '';

        if ($format !== Format::DEFAULT) {
            $prefix = sprintf(
                '%s_',
                $format->value
            );
        }

        return sprintf(
            '%s/%s/%s%s',
            dirname($sourceImage),
            self::SUB_DIR_THUMBNAIL,
            $prefix,
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
