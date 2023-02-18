<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;

class Article implements BlockInterface
{
    /**
     * @param Sujet[] $sujets
     */
    public function __construct(
        private readonly string $title,
        private readonly string $body,
        private readonly Carbon $addedAt,
        private readonly array $sujets,
        private readonly ?Status $status,
        private readonly ?string $url,
        private readonly ?ArticleType $articleType,
        private readonly string $airTableUrl,
        private readonly bool $hasConcept = false,
        private readonly bool $seeAgain = false,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->body;
    }

    public function getAddedAt(): Carbon
    {
        return $this->addedAt;
    }

    public function getType(): BlockType
    {
        return BlockType::ARTICLE_BLOCK;
    }

    public function getSujets(): array
    {
        return $this->sujets;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getArticleType(): ?ArticleType
    {
        return $this->articleType;
    }

    public function getAirTableUrl(): string
    {
        return $this->airTableUrl;
    }

    public function hasConcept(): bool
    {
        return $this->hasConcept;
    }

    public function isSeeAgain(): bool
    {
        return $this->seeAgain;
    }
}
