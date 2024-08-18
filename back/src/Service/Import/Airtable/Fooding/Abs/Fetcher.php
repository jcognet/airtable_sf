<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Abs;

use App\ValueObject\Fooding\Abs;
use Carbon\Carbon;

class Fetcher
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
        /** @var Abs[]|null $items */
        $items = $this->lister->list();

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

    public function getPreviousOccurence(Carbon $date): ?Abs
    {
        $previousOccurence = null;
        $items = $this->fetch();

        if (!$items) {
            return null;
        }

        foreach ($items as $item) {
            /** @var Abs $item */
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
