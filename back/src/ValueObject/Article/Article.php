<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use Carbon\Carbon;

class Article implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'article';

    private string $title;
    private string $body;
    private Carbon $addedAt;
    /**
     * @var Sujet[]
     */
    private array $sujets;

    public function __construct(
        string $title,
        string $body,
        Carbon $addedAt,
        array $sujets
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->addedAt = $addedAt;
        $this->sujets = $sujets;
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

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }

    public function getSujets(): array
    {
        return $this->sujets;
    }
}
