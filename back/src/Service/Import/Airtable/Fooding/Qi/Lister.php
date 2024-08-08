<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Qi;

use App\Service\Import\Airtable\AbstractLister;

class Lister extends AbstractLister
{
    /**
     * @param Qi $a
     * @param Qi $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
