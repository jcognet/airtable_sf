<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coloring;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Fooding\Coloring;

class Lister extends AbstractLister
{
    /**
     * @param Coloring $a
     * @param Coloring $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
