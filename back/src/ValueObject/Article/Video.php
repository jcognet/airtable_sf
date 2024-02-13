<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;

class Video extends AbstractBlock
{
    /**
     * @param Sujet[] $sujets
     */
    public function __construct(
        private readonly string $title,
        private readonly string $body,
        private readonly Carbon $addedAt,
        private readonly array $sujets,
        private readonly ?string $url
    ) {}

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
        return BlockType::VIDEO_BLOCK;
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
        if (null === $this->getUrl() || null === strpos((string) $this->url, 'youtube')) {
            return null;
        }

        $posId = strpos((string) $this->url, 'v=') + 2;
        $posAnd = strpos((string) $this->url, '&');
        $length = $posAnd > 0 ? $posAnd - $posId : strlen((string) $this->url);

        return substr((string) $this->url, $posId, $length);
    }
}
