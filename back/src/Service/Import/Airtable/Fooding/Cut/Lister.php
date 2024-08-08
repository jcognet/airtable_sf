<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Cut;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Fooding\Cut;

class Lister extends AbstractLister
{
    /**
     * @param Cut $a
     * @param Cut $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getDate() <=> $b->getDate();
    }
}
