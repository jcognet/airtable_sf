<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Random\Inr491Repository;
use App\ValueObject\BlockInterface;
use App\ValueObject\Inr\BlockFamille;

class Inr491Manager implements BlockManagerInterface
{
    public function __construct(
        private readonly Inr491Repository $inr491Repository
    ) {}

    public function getContent(): ?BlockInterface
    {
        $famille = $this->inr491Repository->fetchRandomData();

        if ($famille === null) {
            return null;
        }

        return new BlockFamille($famille);
    }
}
