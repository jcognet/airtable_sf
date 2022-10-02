<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;

class Video implements BlockInterface
{
    /**
     * @param Sujet[] $sujets
     */
    public function __construct(private readonly string $title, private readonly string $body, private readonly Carbon $addedAt, private readonly array $sujets, private readonly ?string $url)
    {
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
        return new BlockType(BlockType::VIDEO_BLOCK);
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
