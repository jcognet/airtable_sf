<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ArticleList implements BlockInterface
{
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

    public function getType(): BlockType
    {
        return new BlockType(BlockType::LIST_ARTICLE_BLOCK);
    }

    public function getNbArticles(): int
    {
        return $this->nbArticles;
    }
}
