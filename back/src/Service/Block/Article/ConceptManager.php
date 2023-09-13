<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\ConceptClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class ConceptManager implements BlockManagerInterface
{
    public function __construct(private readonly ConceptClient $conceptClient) {}

    public function getContent(): ?BlockInterface
    {
        $concept = $this->conceptClient->fetchRandomData();
        $this->conceptClient->updateLastUsed($concept);

        return $concept;
    }
}
