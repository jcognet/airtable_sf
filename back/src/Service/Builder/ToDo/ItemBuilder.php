<?php
declare(strict_types=1);

namespace App\Service\Builder\ToDo;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\ToDo\Item;
use Carbon\Carbon;

class ItemBuilder implements BuilderInterface
{
    public function build(array $data)
    {
        return new Item(
            $data['id'],
            Carbon::parse($data['createdTime']),
            $data['fields']['A faire'] ?? null,
            $data['fields']['Notes'] ?? null,
            $data['fields']['Etat'] ?? null,
            isset($data['fields']['Echéance']) ? Carbon::parse($data['fields']['Echéance']) : null,
            $data['fields']['Catégorie'] ?? null,
            $data['fields']['Sprint'] ?? null,
            isset($data['fields']['Prioritaire'])
        );
    }
}
