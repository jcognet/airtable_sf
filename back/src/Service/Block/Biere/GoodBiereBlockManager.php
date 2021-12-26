<?php
declare(strict_types=1);

namespace App\Service\Block\Biere;

use App\Service\AirTable\Biere\BiereClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\Biere\BiereList;
use App\ValueObject\BlockInterface;

class GoodBiereBlockManager implements BlockManagerInterface
{
    private BiereClient $biereClient;

    public function __construct(BiereClient $biereClient)
    {
        $this->biereClient = $biereClient;
    }

    public function getContent(): ?BlockInterface
    {
        $bieres = [
            $this->biereClient->fetchRandomData(['filterByFormula' => '{Note} > 4']),
            $this->biereClient->fetchRandomData(['filterByFormula' => '{Note} > 4']),
        ];

        return new BiereList(
            'Bonnes binouz testées !',
            $bieres
        );
    }
}
