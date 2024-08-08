<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coloring;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Fooding\Coloring;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'coloring.json';
    }

    public function getSubPath(): string
    {
        return 'coloring/';
    }

    public function getDataEntryName(): string
    {
        return 'coloring';
    }

    public function getClass(): string
    {
        return Coloring::class;
    }

    public function getPublicKey(): string
    {
        return 'coloring';
    }

    public function getPublicLabel(): string
    {
        return '';
    }
}
