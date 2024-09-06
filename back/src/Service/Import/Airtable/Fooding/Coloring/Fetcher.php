<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coloring;

use App\Service\Contract\PreviousOccurrenceFetcherInterface;
use App\Service\Import\Airtable\Fooding\AbstractOccurrenceFetcher;
use App\ValueObject\Fooding\Coloring;
use Carbon\Carbon;

class Fetcher extends AbstractOccurrenceFetcher implements PreviousOccurrenceFetcherInterface
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    /**
     * @return Coloring[]|null
     */
    public function fetchBefore(Carbon $date): ?array
    {
        return parent::fetchBefore($date);
    }

    public function getPreviousOccurrence(Carbon $date): ?Coloring
    {
        return parent::getPreviousOccurrence($date);
    }

    /**
     * @return Coloring[]|null
     */
    public function getByMonth(Carbon $date): ?array
    {
        return parent::getByMonth($date);
    }
}
