<?php
declare(strict_types=1);

namespace App\Service\Fooding;

use App\Service\Import\Airtable\Fooding\Coffee\Fetcher as CoffeeFetcher;
use App\Service\Import\Airtable\Fooding\Meat\Fetcher as MeatFetcher;
use App\ValueObject\Fooding\MonthList;
use Carbon\Carbon;

class ConsumptionGetter
{
    public function __construct(
        private readonly CoffeeFetcher $coffeeFetcher,
        private readonly MeatFetcher $meatFetcher
    ) {}

    public function get(Carbon $date): MonthList
    {
        return new MonthList(
            date: $date,
            coffeeList: $this->coffeeFetcher->getByMonth($date),
            meatList: $this->meatFetcher->getByMonth($date),
        );
    }
}
