<?php
declare(strict_types=1);

namespace App\ValueObject\Run;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ListBlockNextRun implements BlockInterface
{
    /**
     * @param NextRun[] $runs
     */
    public function __construct(
        private readonly array $runs,
    ) {
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::NEXT_RUNS);
    }

    public function getTitle(): string
    {
        return 'Prochaines courses';
    }

    /**
     * @return NextRun[]
     */
    public function getContent()
    {
        return $this->runs;
    }
}
