<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;

class ArticleList implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'list_article';

    private string $title;
    private array $articles;
    private int $nbArticles;

    public function __construct(
        string $title,
        array $articles,
        int $nbArticles
    ) {
        $this->title = $title;
        $this->articles = $articles;
        $this->nbArticles = $nbArticles;
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

    public function getNbArticles(): int
    {
        return $this->nbArticles;
    }
}
