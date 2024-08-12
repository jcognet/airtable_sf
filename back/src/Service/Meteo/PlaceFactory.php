<?php
declare(strict_types=1);

namespace App\Service\Meteo;

use App\Service\Import\Airtable\Holiday\Holiday\Fetcher;
use App\ValueObject\Meteo\Place;
use Carbon\Carbon;

class PlaceFactory
{
    private const DEFAULT_LABEL = 'Paris (20e)';
    private const DEFAULT_RESEARCH_KEY = '75120';

    public function __construct(
        private readonly Fetcher $holidayFetcher
    ) {}

    public function make($date): Place
    {
        $place = $this->getPlaceFromHoliday($date);

        if ($place !== null) {
            return $place;
        }

        return $this->makeDefaultPlace();
    }

    private function makeDefaultPlace(): Place
    {
        return new Place(
            label: self::DEFAULT_LABEL,
            researchKey: self::DEFAULT_RESEARCH_KEY
        );
    }

    private function getPlaceFromHoliday(Carbon $date): ?Place
    {
        $holidays = $this->holidayFetcher->fetchFromDate($date);

        if ($holidays === null || count($holidays) === 0) {
            return null;
        }

        return new Place(
            label: $holidays[0]->getPlace(),
            researchKey: $holidays[0]->getPlaceMeteo()
        );
    }
}
