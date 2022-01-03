<?php
declare(strict_types=1);

namespace App\Service\Builder\Meteo;

use App\Service\Builder\BuilderInterface;
use App\Service\Converter\ConvertIntToWeatherType;
use App\ValueObject\Meteo\Weather;

class WeatherBuilder implements BuilderInterface
{
    private ConvertIntToWeatherType $convertIntToWeatherType;

    public function __construct(ConvertIntToWeatherType $convertIntToWeatherType)
    {
        $this->convertIntToWeatherType = $convertIntToWeatherType;
    }

    public function build(array $data)
    {
        return new Weather(
            $data['weather'],
            $this->convertIntToWeatherType->convert($data['weather'])
        );
    }
}
