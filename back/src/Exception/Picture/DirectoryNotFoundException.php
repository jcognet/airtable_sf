<?php
declare(strict_types=1);

namespace App\Exception\Picture;

class DirectoryNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $path)
    {
        parent::__construct(
            sprintf('Unknown directory: %s', $path)
        );
    }
}
