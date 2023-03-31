<?php
declare(strict_types=1);

namespace App\Service\Block;

use App\Service\Archive\DataInputOuputHandler;
use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class BlockFinder
{
    public function __construct(private readonly DataInputOuputHandler $dataInputOuputHandler)
    {
    }

    /**
     * @return BlockInterface[]|null
     */
    public function findByDate(Carbon $date, BlockType $blockType): ?array
    {
        $newsletter = $this->dataInputOuputHandler->get($date);

        if ($newsletter === null) {
            return null;
        }

        return $this->findInNewspaper(
            $newsletter->getNewspaper(),
            $blockType
        );
    }

    public function findInNewspaper(
        Newspaper $newspaper,
        BlockType $blockType
    ): ?array {
        $blocks = [];

        foreach ($newspaper->getBlocks() as $block) {
            if ($block->getType() === $blockType) {
                $blocks[] = $block;
            }
        }

        if (count($blocks) === 0) {
            return null;
        }

        return $blocks;
    }
}
