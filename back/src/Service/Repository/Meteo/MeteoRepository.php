<?php
declare(strict_types=1);

namespace App\Service\Repository\Meteo;

use App\Service\Builder\Meteo\MeteoListBuilder;
use App\ValueObject\Meteo\MeteoList;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MeteoRepository
{
    public function __construct(
        private readonly HttpClientInterface $meteoClient,
        private readonly MeteoListBuilder $meteoListBuilder
    )
    {
    }

    public function fetch(): MeteoList
    {
        $meteoContent = json_decode(
            $this->meteoClient->request(
                'GET',
                'forecast/daily',
                ['query' => ['insee' => 75120]]
            )->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return $this->meteoListBuilder->build($meteoContent);
    }
}
