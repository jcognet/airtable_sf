<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\LuClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class LuBlockManager implements BlockManagerInterface
{
    private LuClient $luClient;

    public function __construct(LuClient $luClient)
    {
        $this->luClient = $luClient;
    }

    public function getContent(): ?BlockInterface
    {
        return $this->luClient->fetchRandomData([
            'filterByFormula' => '{Type} = "Texte"',
        ]);
    }
}
