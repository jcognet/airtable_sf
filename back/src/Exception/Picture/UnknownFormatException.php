<?php
declare(strict_types=1);

namespace App\Exception\Picture;

class UnknownFormatException extends \RuntimeException
{
    public function __construct(string $format, array $list)
    {
        parent::__construct(
            sprintf('Unknown thumbnail format: %s. Allowed are: %s', $format, implode(', ', $list))
        );
    }
}
