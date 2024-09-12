<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\ToDo\Item;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\ToDo\Item;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'items.json';
    }

    public function getSubPath(): string
    {
        return 'to_do/';
    }

    public function getDataEntryName(): string
    {
        return 'items';
    }

    public function getClass(): string
    {
        return Item::class;
    }

    public function getPublicKey(): string
    {
        return 'items';
    }

    public function getPublicLabel(): string
    {
        return 'to do';
    }
}
