<?php
declare(strict_types=1);

namespace App\Service\Builder\Meteo;

use App\Service\Builder\BuilderInterface;
use App\Service\Converter\ConvertIntToWeatherType;
use App\ValueObject\Meteo\Weather;

class WeatherBuilder implements BuilderInterface
{
    public function __construct(private readonly ConvertIntToWeatherType $convertIntToWeatherType)
    {
    }

    public function build(array $data)
    {
        return new Weather(
            $data['weather'],
            $this->convertIntToWeatherType->convert($data['weather'])
        );
    }
}
