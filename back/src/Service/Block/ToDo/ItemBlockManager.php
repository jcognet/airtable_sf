<?php
declare(strict_types=1);

namespace App\Service\Block\ToDo;

use App\Service\AirTable\ToDo\ItemClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\ToDo\ItemList;

class ItemBlockManager implements BlockManagerInterface
{
    public function __construct(private readonly ItemClient $itemClient)
    {
    }

    public function getContent(): ?BlockInterface
    {
        return new ItemList(
            'A faire',
            $this->itemClient->findAll()
        );
    }
}
