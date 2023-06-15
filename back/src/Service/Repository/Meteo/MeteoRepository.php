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

        for ($i = 0; $i <= self::NB_DAYS - 1; ++$i) {
            $place = $this->placeFactory->make($date);
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
            $meteoItemList[] = $this->meteoItemBuilder->build(
                [...$meteoContent['forecast'][$i], ...['place' => $place]]
            );
            $date->addDay();
        }

        return new MeteoList(
            $meteoItemList
        );
    }
}
