<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;

class ArticleList implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'liste_article';

    private string $title;
    private array $articles;

    public function __construct(
        string $title,
        array $articles
    ) {
        $this->title = $title;
        $this->articles = $articles;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->articles;
    }

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }
}
