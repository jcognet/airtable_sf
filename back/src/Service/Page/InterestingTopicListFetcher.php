<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\ValueObject\Article\InterestingTopicList;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;

class InterestingTopicListFetcher
{
    public function __construct(
        private readonly BlockFinder $blockFinder
    ) {
    }

    public function fetch(Newspaper $newspaper): ?InterestingTopicList
    {
        $blocks = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::LIST_ARTICLE_INTERESTING_TOPIC_BLOCK
        );

        if ($blocks !== null) {
            return $blocks[0];
        }

        return null;
    }
}
