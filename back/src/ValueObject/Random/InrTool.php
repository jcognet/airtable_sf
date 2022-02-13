<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

class InrTool
{
    private string $title;
    private string $url;
    /**
     * @var string[]
     */
    private array $tags;
    private string $text;

    /**
     * @param string[] $tags
     */
    public function __construct(
        string $title,
        string $url,
        array $tags,
        string $text
    )
    {
        $this->title = $title;
        $this->url = $url;
        $this->tags = $tags;
        $this->text = $text;
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
