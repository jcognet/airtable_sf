<?php
declare(strict_types=1);

namespace App\Service\Block\Biere;

use App\Service\AirTable\Biere\BiereClient;
use App\Service\Block\CreatorInterface;
use App\ValueObject\BlockInterface;

class GoodBiereCreator implements CreatorInterface
{
    private BiereClient $biereClient;

    public function __construct(BiereClient $biereClient)
    {
        $this->biereClient = $biereClient;
    }

    public function getContent(): BlockInterface
    {
        return $this->biereClient->fetchRandomData(['filterByFormula' => '{Note} > 4']);
    }
}
