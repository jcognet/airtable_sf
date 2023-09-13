<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Random\GoodPracticeOrganizationRepository;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\GoodPracticesList;

class GoodPracticeOrganizationManager implements BlockManagerInterface
{
    private const NB_CRITERIA = 5;

    public function __construct(private readonly GoodPracticeOrganizationRepository $goodPracticeOrganizationRepository) {}

    public function getContent(): ?BlockInterface
    {
        $goodPractices = [];

        for ($i = 1; $i <= self::NB_CRITERIA; ++$i) {
            $goodPractices[] = $this->goodPracticeOrganizationRepository->fetchRandomData();
        }

        return new GoodPracticesList(
            'Bonnes pratiques d\'organisation écoresponsable',
            $goodPractices
        );
    }
}
