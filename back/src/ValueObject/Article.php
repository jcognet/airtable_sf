<?php
declare(strict_types=1);

namespace App\ValueObject;

use Carbon\Carbon;

class Article implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'article';

    private string $title;
    private string $body;
    private Carbon $addedAt;

    public function __construct(
        string $title,
        string $body,
        Carbon $addedAt
    )
    {
        $this->title = $title;
        $this->body = $body;
        $this->addedAt = $addedAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
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
}
