<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\ValueObject\Article\Image;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;

class MainImageFetcher
{
    public function __construct(
        private readonly BlockFinder $blockFinder
    ) {}

    public function fetch(Newspaper $newspaper): ?Image
    {
        $blockImage = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::IMAGE_BLOCK
        );

        if ($blockImage !== null) {
            return $blockImage[0];
        }

        return null;
    }
}
