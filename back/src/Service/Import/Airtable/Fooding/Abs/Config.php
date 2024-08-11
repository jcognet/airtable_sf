<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Abs;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Fooding\Abs;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'abs.json';
    }

    public function getSubPath(): string
    {
        return 'abs/';
    }

    public function getDataEntryName(): string
    {
        return 'abs';
    }

    public function getClass(): string
    {
        return Abs::class;
    }

    public function getPublicKey(): string
    {
        return 'abs';
    }

    public function getPublicLabel(): string
    {
        return 'Abdo';
    }
}
