<?php
declare(strict_types=1);

namespace App\Service\Picture;

use Symfony\Component\String\UnicodeString;

class CachedImageDirectoryGetter
{
    public function __construct(
        private readonly string $cachedImagePath
    ) {
    }

    public function get(
        string $class,
        string $field,
    ): string {
        $shortName = (new \ReflectionClass($class))->getShortName();

        return sprintf(
            '%s%s/%s',
            $this->cachedImagePath,
            (new UnicodeString($shortName))->snake(),
            (new UnicodeString($field))->snake(),
        );
    }
}
