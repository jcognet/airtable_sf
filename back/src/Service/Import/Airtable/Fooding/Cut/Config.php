<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Cut;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Fooding\Cut;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'cut.json';
    }

    public function getSubPath(): string
    {
        return 'cut/';
    }

    public function getDataEntryName(): string
    {
        return 'cut';
    }

    public function getClass(): string
    {
        return Cut::class;
    }

    public function getPublicKey(): string
    {
        return 'cut';
    }

    public function getPublicLabel(): string
    {
        return 'coupes';
    }
}
