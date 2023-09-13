<?php
declare(strict_types=1);

namespace App\Exception\Builder;

class LastUsedUpdaterNotImplementedException extends \RuntimeException
{
    public function __construct(string $class)
    {
        parent::__construct(
            sprintf('The class %s cannot be denormalized.', $class)
        );
    }
}
