<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Holiday\Holiday;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Holiday\Holiday;

class Lister extends AbstractLister
{
    /**
     * @param Holiday $a
     * @param Holiday $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getStartDate() <=> $b->getStartDate();
    }
}
