<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Meat;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Fooding\Meat;

class Lister extends AbstractLister
{
    /**
     * @param Meat $a
     * @param Meat $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
