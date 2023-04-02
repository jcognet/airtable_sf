<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;
use App\ValueObject\Twitter\Message;

class BotDouxFetcher
{
    public function __construct(
        private readonly BlockFinder $blockFinder
    ) {
    }

    public function fetch(Newspaper $newspaper): ?Message
    {
        $blocks = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::BOT_DOUX_BLOCK
        );

        if ($blocks !== null) {
            return $blocks[0];
        }

        return null;
    }
}
