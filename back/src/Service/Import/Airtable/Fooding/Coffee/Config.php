<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coffee;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Fooding\Coffee;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'coffee.json';
    }

    public function getSubPath(): string
    {
        return 'coffee/';
    }

    public function getDataEntryName(): string
    {
        return 'coffee';
    }

    public function getClass(): string
    {
        return Coffee::class;
    }

    public function getPublicKey(): string
    {
        return 'coffee';
    }

    public function getPublicLabel(): string
    {
        return 'cafés';
    }
}
