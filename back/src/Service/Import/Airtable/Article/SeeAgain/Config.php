<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Article\SeeAgain;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Article\Article;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'see_again.json';
    }

    public function getSubPath(): string
    {
        return 'article/';
    }

    public function getDataEntryName(): string
    {
        return 'see_again';
    }

    public function getClass(): string
    {
        return Article::class;
    }

    public function getPublicKey(): string
    {
        return 'see_again';
    }

    public function getPublicLabel(): string
    {
        return 'articles à revoir';
    }
}
