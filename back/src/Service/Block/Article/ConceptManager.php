<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\ConceptClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class ConceptManager implements BlockManagerInterface
{
    private ConceptClient $conceptClient;

    public function __construct(ConceptClient $conceptClient)
    {
        $this->conceptClient = $conceptClient;
    }

    public function getContent(): ?BlockInterface
    {
        return $this->conceptClient->fetchRandomData();
    }
}
