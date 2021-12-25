<?php
declare(strict_types=1);

namespace App\ValueObject;

use Carbon\Carbon;

class Newspaper
{
    private Carbon $createdAt;
    /**
     * @var BlockInterface[]
     */
    private array $blocks;
    private Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->createdAt = Carbon::now();
        $this->date = $date;

        $this->blocks = [];
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function addBlock(?BlockInterface $block): void
    {
        if (null !== $block) {
            $this->blocks[] = $block;
        }
    }
}
