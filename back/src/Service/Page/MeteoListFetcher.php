<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\ValueObject\Meteo\MeteoList;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;

class MeteoListFetcher
{
    public function __construct(
        private readonly BlockFinder $blockFinder
    ) {
    }

    public function fetch(Newspaper $newspaper): ?MeteoList
    {
        $blocks = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::LIST_METEO_BLOCK
        );

        if ($blocks !== null) {
            return $blocks[0];
        }

        return null;
    }
}
