<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\File\File;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Article\File\File;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'files.json';
    }

    public function getSubPath(): string
    {
        return 'file/';
    }

    public function getDataEntryName(): string
    {
        return 'file';
    }

    public function getClass(): string
    {
        return File::class;
    }

    public function getPublicKey(): string
    {
        return 'files';
    }

    public function getPublicLabel(): string
    {
        return 'fichiers';
    }
}
