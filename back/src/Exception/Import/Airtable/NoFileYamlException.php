<?php
declare(strict_types=1);

namespace App\Exception\Import\Airtable;

class NoFileYamlException extends \RuntimeException
{
    public function __construct(string $type, string $fileName)
    {
        parent::__construct(
            sprintf('%s is not listable: %s does not exist.', $type, $fileName)
        );
    }
}
