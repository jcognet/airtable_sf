<?php
declare(strict_types=1);

namespace App\Service\Builder\Meteo;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Meteo\MeteoItem;
use Carbon\Carbon;

class MeteoItemBuilder implements BuilderInterface
{
    private WeatherBuilder $weatherBuilder;

    public function __construct(WeatherBuilder $weatherBuilder)
    {
        $this->weatherBuilder = $weatherBuilder;
    }

    public function build(array $data)
    {
        return new MeteoItem(
            Carbon::parse($data['datetime']),
            $this->weatherBuilder->build($data),
            $data['rr1'],
            $data['probarain'],
            $data['tmin'],
            $data['tmax'],
            $data['sun_hours']
        );
    }
}
