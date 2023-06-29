<?php
declare(strict_types=1);

namespace App\Service\Repository\Meteo;

use App\Service\Builder\Meteo\MeteoItemBuilder;
use App\Service\Meteo\PlaceFactory;
use App\ValueObject\Meteo\MeteoList;
use Carbon\Carbon;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MeteoRepository
{
    private const NB_DAYS = 5;

    public function __construct(
        private readonly HttpClientInterface $meteoClient,
        private readonly MeteoItemBuilder $meteoItemBuilder,
        private readonly PlaceFactory $placeFactory
    ) {
    }

    public function fetch(): MeteoList
    {
        $meteoItemList = [];
        $date = Carbon::now();
        $places = [];

        for ($i = 0; $i <= self::NB_DAYS - 1; ++$i) {
            $places[$i] = $this->placeFactory->make($date);
            $date->addDay();
        }

        $meteoByPlace = [];
        $uniquePlaces = array_unique($places, SORT_REGULAR);

        foreach ($uniquePlaces as $place) {
            $meteoContent = json_decode(
                $this->meteoClient->request(
                    'GET',
                    'forecast/daily',
                    ['query' => [
                        'insee' => $place->getResearchKey(),
                        'update' => $date->format('Y-m-d'),
                    ],
                    ],
                )->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            for ($i = 0; $i <= self::NB_DAYS - 1; ++$i) {
                $meteoByPlace[$place->getResearchKey()][$i] = $this->meteoItemBuilder->build(
                    [...$meteoContent['forecast'][$i], ...['place' => $place]]
                );
            }
        }

        for ($i = 0; $i <= self::NB_DAYS - 1; ++$i) {
            $meteoItemList[] = $meteoByPlace[$places[$i]->getResearchKey()][$i];
        }

        return new MeteoList(
            $meteoItemList
        );
    }
}
