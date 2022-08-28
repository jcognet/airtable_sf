<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Random\InrRepository;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\InrToolList;

class InrManager implements BlockManagerInterface
{
    private const NB_CRITERIA = 4;

    private InrRepository $inrRepository;

    public function __construct(InrRepository $inrRepository)
    {
        $this->inrRepository = $inrRepository;
    }

    public function getContent(): ?BlockInterface
    {
        $inrTools = [];

        for ($i = 1; $i <= self::NB_CRITERIA; ++$i) {
            $inrTools[] = $this->inrRepository->fetchRandomData();
        }

        // Remove null links
        $inrTools = array_filter($inrTools);

        return new InrToolList(
            'Outils conseillés par INR',
            $inrTools
        );
    }
}
