<?php
declare(strict_types=1);

namespace App\Service\Contract;

interface AirtableImporterInterface
{
    public function import(): array;

    public function getLabel(): string;

    public function getConfig(): AirtableConfigInterface;
}
