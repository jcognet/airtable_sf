<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Cut;

use App\Service\Contract\PreviousOccurenceFetcherInterface;
use App\ValueObject\Fooding\Cut;
use Carbon\Carbon;

class Fetcher implements PreviousOccurenceFetcherInterface
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    public function getPreviousOccurence(Carbon $date): ?Cut
    {
        $previousOccurence = null;
        $items = $this->fetch();

        if (!$items) {
            return null;
        }

        foreach ($items as $item) {
            /** @var Cut $item */
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
