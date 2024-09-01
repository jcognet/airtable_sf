<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding;

use App\Service\Contract\OccurrenceInterface;
use Carbon\Carbon;

abstract class AbstractOccurrenceFetcher
{
    abstract public function fetch(): ?array;

    public function getPreviousOccurrence(Carbon $date): ?OccurrenceInterface
    {
        $previousOccurrence = null;
        $items = $this->fetch();

        if (!$items) {
            return null;
        }

        foreach ($items as $item) {
            /** @var OccurrenceInterface $item */
            // Same day, we stop
            if ($item->getDate()->format('dmY') === $date->format('dmY')) {
                return $item;
            }

            if ($item->getDate() <= $date
                && (!$previousOccurrence || $previousOccurrence->getDate() < $item->getDate())
            ) {
                $previousOccurrence = $item;
            }
        }

        return $previousOccurrence;
    }

    public function fetchBefore(Carbon $date): ?array
    {
        /** @var OccurrenceInterface[]|null $items */
        $items = $this->fetch();

        if (!$items) {
            return null;
        }

        $itemsBefore = [];

        foreach ($items as $item) {
            // We know it is sorted by date
            if ($item->getDate() > $date) {
                break;
            }

            $itemsBefore[] = $item;
        }

        return $itemsBefore;
    }
}
