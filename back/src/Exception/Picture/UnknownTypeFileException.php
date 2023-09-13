<?php
declare(strict_types=1);

namespace App\Exception\Picture;

class UnknownTypeFileException extends \RuntimeException
{
    public function __construct(string $format, array $list)
    {
        parent::__construct(
            sprintf('Format not handled: %s. Allowed are: %s', $format, implode(', ', $list))
        );
    }
}
