<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coffee;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Fooding\Coffee;

class Lister extends AbstractLister
{
    /**
     * @param Coffee $a
     * @param Coffee $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
