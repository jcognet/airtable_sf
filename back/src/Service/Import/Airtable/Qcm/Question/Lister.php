<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Qcm\Question;

class Lister extends AbstractLister
{
    /**
     * @param Question $a
     * @param Question $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getLastUsed() <=> $b->getLastUsed();
    }
}
