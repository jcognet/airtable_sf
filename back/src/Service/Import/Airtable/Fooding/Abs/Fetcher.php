<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Abs;

use App\Service\Import\Airtable\Fooding\AbstractOccurrenceFetcher;
use App\ValueObject\Fooding\Abs;
use Carbon\Carbon;

class Fetcher extends AbstractOccurrenceFetcher
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    /**
     * @return Abs[]|null
     */
    public function fetchBefore(Carbon $date): ?array
    {
        return parent::fetchBefore($date);
    }

    public function getPreviousOccurrence(Carbon $date): ?Abs
    {
        return parent::getPreviousOccurrence($date);
    }
}
