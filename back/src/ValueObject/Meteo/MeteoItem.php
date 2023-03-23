<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

use Carbon\Carbon;

class MeteoItem
{
    public function __construct(
        private readonly Carbon $day,
        private readonly Weather $weather,
        private readonly float $rain,
        private readonly int $probaRain,
        private readonly int $temperatureMin,
        private readonly int $temperatureMax,
        private readonly int $sunHours
    ) {
    }

    public function getDay(): Carbon
    {
        return $this->day;
    }

    public function getWeather(): Weather
    {
        return $this->weather;
    }

    public function getRain(): float
    {
        return $this->rain;
    }

    public function getProbaRain(): int
    {
        return $this->probaRain;
    }

    public function getTemperatureMin(): int
    {
        return $this->temperatureMin;
    }

    public function getTemperatureMax(): int
    {
        return $this->temperatureMax;
    }

    public function getSunHours(): int
    {
        return $this->sunHours;
    }
}
