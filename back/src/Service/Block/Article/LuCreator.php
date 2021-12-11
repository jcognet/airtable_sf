<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\LuClient;
use App\Service\Block\CreatorInterface;
use App\ValueObject\BlockInterface;

class LuCreator implements CreatorInterface
{
    private LuClient $luClient;

    public function __construct(LuClient $luClient)
    {
        $this->luClient = $luClient;
    }

    public function getContent(): BlockInterface
    {
        return $this->luClient->fetchRandomData([
            'filterByFormula' => '{Type} = "Texte"',
        ]);
    }
}
