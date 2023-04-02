<?php
declare(strict_types=1);

namespace App\Enum\Picture;

use App\Exception\Picture\UnknownFormatException;

enum Format: string
{
    case DEFAULT = 'default';
    case NEWSLETTER_WIDTH = 'newsletter_width';
    case LIST_BEER = 'list_beer';
    case MAIN_IMAGE = 'main_image';
    case MAIN_IMAGE_PREVIOUS = 'main_image_previous';

    public static function make(?string $type): self
    {
        if ($type === null) {
            return self::DEFAULT;
        }

        foreach (self::cases() as $case) {
            if ($case->value === $type) {
                return $case;
            }
        }

        throw new UnknownFormatException(
            $type,
            array_map(
                fn ($format) => $format->value,
                self::cases()
            )
        );
    }
}
