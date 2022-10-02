<?php
declare(strict_types=1);

namespace App\ValueObject;

use Carbon\Carbon;

class Newspaper
{
    private readonly Carbon $createdAt;
    /**
     * @var BlockInterface[]
     */
    private array $blocks = [];

    public function __construct(private readonly Carbon $date)
    {
        $this->createdAt = Carbon::now();
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function addBlock(?BlockInterface $block): void
    {
        if (null !== $block) {
            $this->blocks[] = $block;
        }
    }
}
