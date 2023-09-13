<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Meat;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Fooding\Meat;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'meat.json';
    }

    public function getSubPath(): string
    {
        return 'meat/';
    }

    public function getDataEntryName(): string
    {
        return 'meat';
    }

    public function getClass(): string
    {
        return Meat::class;
    }

    public function getPublicKey(): string
    {
        return 'meat';
    }

    public function getPublicLabel(): string
    {
        return 'viandes';
    }
}
