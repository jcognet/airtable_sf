<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;

class Article implements BlockInterface
{
    private string $title;
    private string $body;
    private Carbon $addedAt;

    /**
     * @var Sujet[]
     */
    private array $sujets;
    private ?Status $status;
    private ?string $url;

    public function __construct(
        string $title,
        string $body,
        Carbon $addedAt,
        array $sujets,
        ?Status $status,
        ?string $url
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->addedAt = $addedAt;
        $this->sujets = $sujets;
        $this->status = $status;
        $this->url = $url;
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
        return new BlockType(BlockType::ARTICLE_BLOCK);
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
}
