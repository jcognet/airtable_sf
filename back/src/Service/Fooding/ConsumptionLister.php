<?php
declare(strict_types=1);

namespace App\Service\Fooding;

use App\Service\Import\Airtable\Fooding\Coffee\Lister as CoffeeLister;
use App\Service\Import\Airtable\Fooding\Meat\Lister as MeatLister;
use App\ValueObject\Fooding\Coffee;
use App\ValueObject\Fooding\Meat;
use App\ValueObject\Fooding\MonthList;
use Carbon\Carbon;

class ConsumptionLister
{
    public function __construct(
        private readonly CoffeeLister $coffeeLister,
        private readonly MeatLister $meatLister,
    ) {}

    /**
     * @return MonthList[]|null
     */
    public function list(): ?array
    {
        $coffeeList = $this->coffeeLister->list();
        $listByYearMonth = [];

        /**
         * @var Coffee $coffee
         */
        foreach ($coffeeList as $coffee) {
            $monthYear = $coffee->getDate()->format('Y-m');

            if (!array_key_exists($monthYear, $listByYearMonth)) {
                $listByYearMonth[$monthYear]['meat'] = [];
                $listByYearMonth[$monthYear]['coffee'] = [];
            }

            $listByYearMonth[$monthYear]['coffee'][] = $coffee;
        }

        $meatList = $this->meatLister->list();

        /**
         * @var Meat $meat
         */
        foreach ($meatList as $meat) {
            $monthYear = $meat->getDate()->format('Y-m');

            if (!array_key_exists($monthYear, $listByYearMonth)) {
                $listByYearMonth[$monthYear]['meat'] = [];
                $listByYearMonth[$monthYear]['coffee'] = [];
            }

            $listByYearMonth[$monthYear]['meat'][] = $meat;
        }

        if (!$listByYearMonth) {
            return null;
        }

        $listMonthList = [];

        foreach ($listByYearMonth as $monthYear => $value) {
            $listMonthList[] = new MonthList(
                Carbon::createFromFormat('Y-m', $monthYear),
                $value['coffee'],
                $value['meat']
            );
        }

        return $listMonthList;
    }
}
