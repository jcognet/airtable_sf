<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Article\ALire;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Article\Article;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'to_read.json';
    }

    public function getSubPath(): string
    {
        return 'article/';
    }

    public function getDataEntryName(): string
    {
        return 'to_read';
    }

    public function getClass(): string
    {
        return Article::class;
    }

    public function getPublicKey(): string
    {
        return 'to_read';
    }

    public function getPublicLabel(): string
    {
        return 'articles à lire';
    }
}
