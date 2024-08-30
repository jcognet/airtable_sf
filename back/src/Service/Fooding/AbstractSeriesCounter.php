<?php
declare(strict_types=1);

namespace App\Service\Fooding;

use Carbon\Carbon;

abstract class AbstractSeriesCounter
{
    public function countCurrentSeries(Carbon $date): ?int
    {
        $events = $this->fetchBefore($date);

        if (!$events) {
            return null;
        }

        $previousDay = null;
        $nbCurrent = 1;
        foreach (array_reverse($events) as $event) {
            // First iteration
            if (!$previousDay) {
                $previousDay = $event->getDate();

                continue;
            }

            $previousDay->subDay();
            if ($previousDay->format('dmY') === $event->getDate()->format('dmY')) {
                ++$nbCurrent;
            } else {
                break;
            }

            $previousDay = $event->getDate()->copy();
        }

        return $nbCurrent;
    }

    public function countCurrentSeriesWithout(Carbon $date): ?int
    {
        $events = $this->fetchBefore($date);

        if (!$events) {
            return null;
        }

        $lastEvent = end($events);

        return $lastEvent->getDate()->diffInDays($date);
    }

    public function countSeriesMax(Carbon $date): ?int
    {
        $events = $this->fetchBefore($date);

        if (!$events) {
            return null;
        }

        $previousDay = null;
        $nbMax = 0;
        $nbCurrent = 1;
        foreach ($events as $event) {
            // First iteration
            if (!$previousDay) {
                $previousDay = $event->getDate();

                continue;
            }

            $previousDay->addDay();
            if ($previousDay->format('dmY') === $event->getDate()->format('dmY')) {
                ++$nbCurrent;
            } else {
                $nbMax = max($nbMax, $nbCurrent);
                $nbCurrent = 1;
            }

            $previousDay = $event->getDate()->copy();
        }

        return $nbMax;
    }

    abstract protected function fetchBefore(Carbon $date): ?array;
}
