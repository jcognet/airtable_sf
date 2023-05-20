<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;
use App\ValueObject\Random\ImageUrl;

class RandomPicFetcher
{
    public function __construct(
        private readonly BlockFinder $blockFinder
    ) {
    }

    public function fetch(Newspaper $newspaper): ?ImageUrl
    {
        $block = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::IMAGE_URL_BLOCK
        );

        if ($block !== null) {
            return $block[0];
        }

        return null;
    }
}
