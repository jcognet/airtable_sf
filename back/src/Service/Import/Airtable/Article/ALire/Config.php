<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Article\ALire;

use App\Service\Builder\Article\ArticleToReadBuilder;
use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Article\Article;
use App\ValueObject\Holiday\Holiday;

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
}
