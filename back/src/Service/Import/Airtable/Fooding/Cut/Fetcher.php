<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Cut;

use App\Service\Contract\PreviousOccurrenceFetcherInterface;
use App\Service\Import\Airtable\Fooding\AbstractOccurrenceFetcher;
use App\ValueObject\Fooding\Cut;
use Carbon\Carbon;

class Fetcher extends AbstractOccurrenceFetcher implements PreviousOccurrenceFetcherInterface
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    public function getPreviousOccurrence(Carbon $date): ?Cut
    {
        return parent::getPreviousOccurrence($date);
    }

    /**
     * @return Cut[]|null
     */
    public function fetchBefore(Carbon $date): ?array
    {
        return parent::fetchBefore($date);
    }

    /**
     * @return Cut[]|null
     */
    public function getByMonth(Carbon $date): ?array
    {
        return parent::getByMonth($date);
    }
}
