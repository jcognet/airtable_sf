<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coloring;

use App\Service\Contract\PreviousOccurenceFetcherInterface;
use App\ValueObject\Fooding\Coloring;
use Carbon\Carbon;

class Fetcher implements PreviousOccurenceFetcherInterface
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    public function getPreviousOccurence(Carbon $date): ?Coloring
    {
        $previousOccurence = null;
        $items = $this->fetch();

        if (!$items) {
            return null;
        }

        foreach ($items as $item) {
            /** @var Coloring $item */
            // Same day, we stop
            if ($item->getDate()->format('dmY') === $date->format('dmY')) {
                return $item;
            }

            if ($item->getDate() <= $date
                && (!$previousOccurence || $previousOccurence->getDate() < $item->getDate())
            ) {
                $previousOccurence = $item;
            }
        }

        return $previousOccurence;
    }
}
