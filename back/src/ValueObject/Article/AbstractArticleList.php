<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

abstract class AbstractArticleList implements BlockInterface
{
    /**
     * @param Article[] $articles
     */
    public function __construct(
        private readonly string $title,
        private readonly array $articles,
        private readonly int $nbArticles
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->articles;
    }

    abstract public function getType(): BlockType;

    public function getNbArticles(): int
    {
        return $this->nbArticles;
    }
}
