<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\File\File;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Article\File\File;

class Lister extends AbstractLister
{
    /**
     * @param File $a
     * @param File $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getTitle() <=> $b->getTitle();
    }
}
