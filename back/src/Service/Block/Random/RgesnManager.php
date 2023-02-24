<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Random\RgesnRepository;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\CriteriaList;

class RgesnManager implements BlockManagerInterface
{
    private const NB_CRITERIA = 3;

    public function __construct(private readonly RgesnRepository $rgesnRepository)
    {
    }

    public function getContent(): ?BlockInterface
    {
        $criterias = [];

        for ($i = 1; $i <= self::NB_CRITERIA; ++$i) {
            $criterias[] = $this->rgesnRepository->fetchRandomData();
        }

        return new CriteriaList(
            'RGESN',
            $criterias
        );
    }
}
