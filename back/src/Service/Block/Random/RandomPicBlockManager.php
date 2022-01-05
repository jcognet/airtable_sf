<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Random\RandomImageRepositoryInterface;
use App\ValueObject\BlockInterface;

class RandomPicBlockManager implements BlockManagerInterface
{
    /**
     * @var RandomImageRepositoryInterface[]
     */
    private array $repositories;

    public function __construct(
        iterable $repositories
    ) {
        $this->repositories = iterator_to_array($repositories);
    }

    public function getContent(): ?BlockInterface
    {
        return $this->repositories[array_rand($this->repositories)]->fetchRandomData();
    }
}
