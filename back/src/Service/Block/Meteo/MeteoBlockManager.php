<?php
declare(strict_types=1);

namespace App\Service\Block\Meteo;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Meteo\MeteoRepository;
use App\ValueObject\BlockInterface;

class MeteoBlockManager implements BlockManagerInterface
{
    private MeteoRepository $meteoRepository;

    public function __construct(MeteoRepository $meteoRepository)
    {
        $this->meteoRepository = $meteoRepository;
    }

    public function getContent(): ?BlockInterface
    {
        return $this->meteoRepository->fetch();
    }
}
