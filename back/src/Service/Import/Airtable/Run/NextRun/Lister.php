<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Run\NextRun;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Run\NextRun;

class Lister extends AbstractLister
{
    /**
     * @param NextRun $a
     * @param NextRun $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
