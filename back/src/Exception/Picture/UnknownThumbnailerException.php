<?php
declare(strict_types=1);

namespace App\Exception\Picture;

class UnknownThumbnailerException extends \RuntimeException
{
    public function __construct($sourceImage)
    {
        parent::__construct(
            sprintf('Unknown thumbnail %s.', $sourceImage)
        );
    }
}
