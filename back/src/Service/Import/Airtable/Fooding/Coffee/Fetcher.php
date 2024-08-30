<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coffee;

use App\ValueObject\Fooding\Coffee;
use Carbon\Carbon;

class Fetcher
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    public function getByMonth(Carbon $date): ?array
    {
        $list = $this->fetch();
        $listByMonth = [];

        if (!$list) {
            return null;
        }

        foreach ($list as $coffee) {
            /** @var Coffee $coffee */
            if ($coffee->getDate()->format('mY') === $date->format('mY')) {
                $listByMonth[] = $coffee;
            }
        }

        return $listByMonth;
    }

    /**
     * @return Coffee[]|null
     */
    public function fetchBefore(Carbon $date): ?array
    {
        /** @var Coffee[]|null $items */
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
