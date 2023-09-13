<?php
declare(strict_types=1);

namespace App\ValueObject\Official;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Passport extends AbstractBlock
{
    public function __construct(
        private readonly string $url
    ) {}

    public function getTitle(): string
    {
        return 'Passport + CI ?';
    }

    public function getContent()
    {
        return $this->url;
    }

    public function getType(): BlockType
    {
        return BlockType::PASSPORT;
    }
}
