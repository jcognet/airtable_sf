<?php
declare(strict_types=1);

namespace App\Exception\Import\Airtable;

class UnknownListServiceException extends \RuntimeException
{
    public function __construct(string $type, string $callingClass)
    {
        parent::__construct(
            sprintf('%s is not listable because the services is unknown in %s.', $type, $callingClass)
        );
    }
}
