<?php
declare(strict_types=1);

namespace App\Exception\Import\Airtable;

class UnknownDataImportedTypeException extends \RuntimeException
{
    public function __construct(string $type, array $list)
    {
        parent::__construct(
            sprintf('Unknown data imported type: %s. Allowed are: %s', $type, implode(', ', $list))
        );
    }
}
