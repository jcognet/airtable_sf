<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

abstract class AbstractArticleList implements BlockInterface
{
    private string $title;
    /**
     * @var Article[]
     */
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

    abstract public function getType(): BlockType;

    public function getNbArticles(): int
    {
        return $this->nbArticles;
    }
}
