<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Qi;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Fooding\Qi;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'qi.json';
    }

    public function getSubPath(): string
    {
        return 'qi/';
    }

    public function getDataEntryName(): string
    {
        return 'qi';
    }

    public function getClass(): string
    {
        return Qi::class;
    }

    public function getPublicKey(): string
    {
        return 'qi';
    }

    public function getPublicLabel(): string
    {
        return '';
    }
}
