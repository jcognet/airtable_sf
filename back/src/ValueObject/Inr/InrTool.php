<?php
declare(strict_types=1);

namespace App\ValueObject\Inr;

class InrTool
{
    /**
     * @param string[] $tags
     */
    public function __construct(private readonly string $title, private readonly string $url, private readonly array $tags, private readonly string $text)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
