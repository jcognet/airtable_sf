<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Abs;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Fooding\Abs;

class Lister extends AbstractLister
{
    /**
     * @param Abs $a
     * @param Abs $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
