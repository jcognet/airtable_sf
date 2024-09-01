<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Qi;

use App\Service\Contract\PreviousOccurrenceFetcherInterface;
use App\Service\Import\Airtable\Fooding\AbstractOccurrenceFetcher;
use App\ValueObject\Fooding\Qi;
use Carbon\Carbon;

class Fetcher extends AbstractOccurrenceFetcher implements PreviousOccurrenceFetcherInterface
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    public function getPreviousOccurrence(Carbon $date): ?Qi
    {
        return parent::getPreviousOccurrence($date);
    }
}
