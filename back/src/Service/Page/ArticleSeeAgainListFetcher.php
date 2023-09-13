<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\ValueObject\Article\ArticleSeeAgainList;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;

class ArticleSeeAgainListFetcher
{
    public function __construct(
        private readonly BlockFinder $blockFinder
    ) {}

    public function fetch(Newspaper $newspaper): ?ArticleSeeAgainList
    {
        $blocks = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::SEE_AGAIN
        );

        if ($blocks !== null) {
            return $blocks[0];
        }

        return null;
    }
}
