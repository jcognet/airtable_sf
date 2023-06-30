<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Article\SeeAgain;

use App\Service\Import\Airtable\AbstractLister;
use App\ValueObject\Article\Article;

class Lister extends AbstractLister
{
    /**
     * @param Article $a
     * @param Article $b
     */
    protected static function sort($a, $b): int
    {
        return $a->getTitle() <=> $b->getTitle();
    }
}
