<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Meat;

use App\Service\Import\Airtable\Fooding\AbstractOccurrenceFetcher;
use App\ValueObject\Fooding\Meat;
use Carbon\Carbon;

class Fetcher extends AbstractOccurrenceFetcher
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    /**
     * @return Meat[]|null
     */
    public function getByMonth(Carbon $date): ?array
    {
        return parent::getByMonth($date);
    }

    /**
     * @return Meat[]|null
     */
    public function fetchBefore(Carbon $date): ?array
    {
        return parent::fetchBefore($date);
    }

    public function getPreviousOccurrence(Carbon $date): ?Meat
    {
        return parent::getPreviousOccurrence($date);
    }
}
