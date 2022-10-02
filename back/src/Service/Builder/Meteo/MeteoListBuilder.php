<?php
declare(strict_types=1);

namespace App\Service\Builder\Meteo;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Meteo\MeteoList;

class MeteoListBuilder implements BuilderInterface
{
    private const NB_DAYS = 5;

    public function __construct(private readonly MeteoItemBuilder $meteoItemBuilder)
    {
    }

    public function build(array $data)
    {
        $meteoItems = [];

        for ($i = 0; $i <= self::NB_DAYS - 1; ++$i) {
            $meteoItems[] = $this->meteoItemBuilder->build($data['forecast'][$i]);
        }

        return new MeteoList(
            $meteoItems,
            (string) $data['city']['latitude'],
            (string) $data['city']['longitude'],
        );
    }
}
