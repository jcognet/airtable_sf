<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use Carbon\Carbon;

class Video implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'video';

    private string $title;
    private string $body;
    private Carbon $addedAt;
    /**
     * @var Sujet[]
     */
    private array $sujets;
    private ?string $url;

    public function __construct(
        string $title,
        string $body,
        Carbon $addedAt,
        array $sujets,
        ?string $url
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->addedAt = $addedAt;
        $this->sujets = $sujets;
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

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }

    public function getSujets(): array
    {
        return $this->sujets;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getVideoId(): ?string
    {
        if (null === $this->getUrl() || null === strpos($this->url, 'youtube')) {
            return null;
        }

        $posId = strpos($this->url, 'v=') + 2;
        $posAnd = strpos($this->url, '&');
        $length = $posAnd > 0 ? $posAnd - $posId : strlen($this->url);

        return substr($this->url, $posId, $length);
    }
}
