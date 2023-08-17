<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Article\SeeAgain;

use App\Service\Import\Airtable\AbstractFilter;

class Filter extends AbstractFilter
{
    public function getFilterGetter(): array
    {
        return ['title', 'content'];
    }
}
