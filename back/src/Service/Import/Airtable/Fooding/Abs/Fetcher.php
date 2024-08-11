<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Abs;

use App\ValueObject\Fooding\Abs;
use Carbon\Carbon;

class Fetcher
{
    public function __construct(private readonly Lister $lister) {}

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
}
