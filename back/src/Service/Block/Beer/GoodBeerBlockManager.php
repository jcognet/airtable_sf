<?php
declare(strict_types=1);

namespace App\Service\Block\Beer;

use App\Service\AirTable\Beer\BeerClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\Beer\BeerList;
use App\ValueObject\BlockInterface;

class GoodBeerBlockManager implements BlockManagerInterface
{
    private BeerClient $beerClient;

    public function __construct(BeerClient $beerClient)
    {
        $this->beerClient = $beerClient;
    }

    public function getContent(): ?BlockInterface
    {
        $beers = [
            $this->beerClient->fetchRandomData(['filterByFormula' => '{Note} > 4']),
            $this->beerClient->fetchRandomData(['filterByFormula' => '{Note} > 4']),
        ];

        return new BeerList(
            'Bonnes binouz testées !',
            $beers
        );
    }
}
