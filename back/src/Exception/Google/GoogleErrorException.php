<?php
declare(strict_types=1);

namespace App\Exception\Google;

class GoogleErrorException extends \RuntimeException
{
    public function __construct(string $code)
    {
        parent::__construct(
            sprintf('Error while querying google place: %s.', $code)
        );
    }
}
