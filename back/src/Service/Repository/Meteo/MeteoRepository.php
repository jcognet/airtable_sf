<?php
declare(strict_types=1);

namespace App\Service\Repository\Meteo;

use App\Service\Builder\Meteo\MeteoListBuilder;
use App\ValueObject\Meteo\MeteoList;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MeteoRepository
{
    private HttpClientInterface $meteoClient;
    private MeteoListBuilder $meteoListBuilder;

    public function __construct(
        HttpClientInterface $meteoClient,
        MeteoListBuilder $meteoListBuilder
    ) {
        $this->meteoClient = $meteoClient;
        $this->meteoListBuilder = $meteoListBuilder;
    }

    public function fetch(): MeteoList
    {
        $meteoContent = json_decode(
            $this->meteoClient->request(
                'GET',
                'forecast/daily',
                ['query' => ['insee' => 75120]]
            )->getContent(),
            true
        );

        return $this->meteoListBuilder->build($meteoContent);
    }
}
