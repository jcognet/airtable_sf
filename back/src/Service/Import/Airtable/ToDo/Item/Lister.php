<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\ToDo\Item;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\ToDo\Item;

class Lister extends AbstractLister
{
    /**
     * @param Item $a
     * @param Item $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDueAt() <=> $b->getDueAt();
    }
}
