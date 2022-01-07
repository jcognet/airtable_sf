<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Random\RgsenRepository;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\CriteriaList;

class RgsenManager implements BlockManagerInterface
{
    private const NB_CRITERIA = 3;

    private RgsenRepository $rgsenRepository;

    public function __construct(RgsenRepository $rgsenRepository)
    {
        $this->rgsenRepository = $rgsenRepository;
    }

    public function getContent(): ?BlockInterface
    {
        $criterias = [];

        for ($i = 1; $i <= self::NB_CRITERIA; ++$i) {
            $criterias[] = $this->rgsenRepository->fetchRandomData();
        }

        return new CriteriaList(
            'RGSEN',
            $criterias
        );
    }
}
