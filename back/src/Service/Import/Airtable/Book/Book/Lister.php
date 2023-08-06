<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Book\Book;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Book\Book;

class Lister extends AbstractLister
{
    /**
     * @param Book $a
     * @param Book $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getTitle() <=> $b->getTitle();
    }
}
