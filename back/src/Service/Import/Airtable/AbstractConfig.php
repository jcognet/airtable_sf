<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Service\Contract\AirtableConfigInterface;

abstract class AbstractConfig implements AirtableConfigInterface
{
    public function __construct(
        private readonly string $projectDir
    ) {
    }

    abstract public function getFileName(): string;

    abstract public function getSubPath(): string;

    abstract public function getClass(): string;

    public function getCompleteName(): string
    {
        return sprintf(
            '%s%s%s',
            $this->getPath(),
            $this->getSubPath(),
            $this->getFileName()
        );
    }

    private function getPath(): string
    {
        return sprintf('%s/src/Data/', $this->projectDir);
    }
}
