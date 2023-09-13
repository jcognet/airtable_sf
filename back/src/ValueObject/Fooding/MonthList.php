<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use Carbon\Carbon;

class MonthList
{
    /**
     * @param Coffee[]|null $coffeeList
     * @param Meat[]|null $meatList
     */
    public function __construct(
        private readonly Carbon $date,
        private readonly ?array $coffeeList,
        private readonly ?array $meatList
    ) {}

    public function getDaysFromMonth(): array
    {
        $list = [];
        $days = range(
            1,
            $this->date->lastOfMonth()->format('d')
        );

        foreach ($days as $day) {
            $list[] = Carbon::parse(
                sprintf(
                    '%d-%d-%d',
                    $this->date->year,
                    $this->date->month,
                    $day
                )
            );
        }

        // We start the graph from monday
        $firstDayMonth = $list[0];
        $posFirstDayInWeek = (int) $firstDayMonth->format('N');
        if ($posFirstDayInWeek !== 1) { // Not Monday
            $tmpDate = $firstDayMonth->copy();

            for ($i = 0; $i < $posFirstDayInWeek - 1; ++$i) {
                $tmpDate->subDay();
                array_unshift(
                    $list,
                    Carbon::parse(
                        sprintf(
                            '%d-%d-%d',
                            $tmpDate->year,
                            $tmpDate->month,
                            $tmpDate->day
                        )
                    )
                );
            }
        }

        $lastDayMonth = end($list);
        $posLastDayInWeek = (int) $lastDayMonth->format('N');

        if ($posLastDayInWeek !== 7) { // Not Sunday
            $tmpDate = $lastDayMonth->copy();

            for ($i = $posLastDayInWeek; $i < 7; ++$i) {
                $tmpDate->addDay();
                $list[] = Carbon::parse(
                    sprintf(
                        '%d-%d-%d',
                        $tmpDate->year,
                        $tmpDate->month,
                        $tmpDate->day
                    )
                );
            }
        }

        return $list;
    }

    public function getNbCoffeeByDay(Carbon $date): int
    {
        if ($this->coffeeList === null) {
            return 0;
        }

        foreach ($this->coffeeList as $coffee) {
            if ($coffee->getDate()->format('dmY') === $date->format('dmY')) {
                return $coffee->getQuantity();
            }
        }

        return 0;
    }

    public function getNbMeatByDay(Carbon $date): int
    {
        if ($this->meatList === null) {
            return 0;
        }

        foreach ($this->meatList as $meat) {
            if ($meat->getDate()->format('dmY') === $date->format('dmY')) {
                $nb = $meat->isDinner() ? 1 : 0;

                return $nb + ($meat->isLunch() ? 1 : 0);
            }
        }

        return 0;
    }
}
