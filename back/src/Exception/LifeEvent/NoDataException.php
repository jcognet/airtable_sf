<?php
declare(strict_types=1);

namespace App\Exception\LifeEvent;

class NoDataException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'No data was found.'
        );
    }
}
