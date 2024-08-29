<?php
declare(strict_types=1);

namespace App\Exception\Children;

class NoDataException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'No data was found.'
        );
    }
}
