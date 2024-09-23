<?php
declare(strict_types=1);

namespace App\Exception\LifeEvent;

class WrongFormatException extends \RuntimeException
{
    public function __construct(string $content)
    {
        parent::__construct(
            sprintf(
                'Content given is not a JSON string: %s.',
                $content
            )
        );
    }
}
