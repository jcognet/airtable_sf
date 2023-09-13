<?php
declare(strict_types=1);

namespace App\Exception\NewsletterBlockManager;

class UnknownManagerTypeException extends \RuntimeException
{
    public function __construct(string $format, array $list)
    {
        parent::__construct(
            sprintf('Unknown manager type: %s. Allowed are: %s', $format, implode(', ', $list))
        );
    }
}
