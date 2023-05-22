<?php
declare(strict_types=1);

namespace App\Service\Repository\Meteo;

use App\Service\Builder\Meteo\MeteoListBuilder;
use App\Service\Meteo\PlaceFactory;
use App\ValueObject\Meteo\MeteoList;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MeteoRepository
{
    public function __construct(
        private readonly HttpClientInterface $meteoClient,
        private readonly MeteoListBuilder $meteoListBuilder,
        private readonly PlaceFactory $placeFactory
    ) {
    }

    public function fetch(): MeteoList
    {
        $place = $this->placeFactory->make();

        $meteoContent = json_decode(
            $this->meteoClient->request(
                'GET',
                'forecast/daily',
                ['query' => ['insee' => $place->getResearchKey()]]
            )->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $meteoList = $this->meteoListBuilder->build($meteoContent);
        $meteoList->setPlace($place);

        return $meteoList;
    }
}
