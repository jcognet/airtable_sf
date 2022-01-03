<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

use Carbon\Carbon;

class MeteoItem
{
    private Carbon $day;
    private Weather $weather;
    private float $rain;
    private int $probaRain;
    private int $temperatureMin;
    private int $temperatureMax;
    private int $sunHours;

    public function __construct(Carbon $day, Weather $weather, float $rain, int $probaRain, int $temperatureMin, int $temperatureMax, int $sunHours)
    {
        $this->day = $day;
        $this->weather = $weather;
        $this->rain = $rain;
        $this->probaRain = $probaRain;
        $this->temperatureMin = $temperatureMin;
        $this->temperatureMax = $temperatureMax;
        $this->sunHours = $sunHours;
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
