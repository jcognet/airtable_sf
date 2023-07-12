<?php
declare(strict_types=1);

namespace App\Exception\Picture;

class DirectoryNotZippableException extends \RuntimeException
{
    public function __construct(string $dir)
    {
        parent::__construct(
            sprintf('File not zippable: %s.', $dir)
        );
    }
}
