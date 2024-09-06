<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coffee;

use App\Service\Import\Airtable\Fooding\AbstractOccurrenceFetcher;
use App\ValueObject\Fooding\Coffee;
use Carbon\Carbon;

class Fetcher extends AbstractOccurrenceFetcher
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    /**
     * @return Coffee[]|null
     */
    public function fetchBefore(Carbon $date): ?array
    {
        return parent::fetchBefore($date);
    }

    public function getPreviousOccurrence(Carbon $date): ?Coffee
    {
        return parent::getPreviousOccurrence($date);
    }

    /**
     * @return Coffee[]|null
     */
    public function getByMonth(Carbon $date): ?array
    {
        return parent::getByMonth($date);
    }
}
