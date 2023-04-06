<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class InrManager implements BlockManagerInterface
{
    public function getContent(): ?BlockInterface
    {
        return null;
        //        $inrTools = [];
        //
        //        for ($i = 1; $i <= self::NB_CRITERIA; ++$i) {
        //            $inrTools[] = $this->inrRepository->fetchRandomData();
        //        }
        //
        //        // Remove null links
        //        $inrTools = array_filter($inrTools);
        //
        //        return new InrToolList(
        //            'Outils conseillés par INR',
        //            $inrTools
        //        );
    }
}
