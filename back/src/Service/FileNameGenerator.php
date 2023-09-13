<?php
declare(strict_types=1);

namespace App\Service;

class FileNameGenerator
{
    public function generate(
        string $name,
        string $extension
    ): string {
        return sprintf(
            '%s.%s',
            preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($name))),
            $extension
        );
    }
}
