<?php
declare(strict_types=1);

namespace App\Enum\Import\Airtable;

use App\Exception\Picture\UnknownFormatException;

enum Order: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public static function make(?string $order): self
    {
        if ($order === null) {
            return self::ASC;
        }

        foreach (self::cases() as $case) {
            if ($case->value === strtolower($order)) {
                return $case;
            }
        }

        throw new UnknownFormatException(
            $order,
            array_map(
                static fn ($format) => $format->value,
                self::cases()
            )
        );
    }
}
