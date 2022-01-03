<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\AirTable\FetchDataInterface;
use App\Service\Builder\Random\StarBuilder;
use App\ValueObject\BlockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StarRepository implements FetchDataInterface
{
    private HttpClientInterface $httpClient;
    private StarBuilder $starBuilder;

    public function __construct(HttpClientInterface $httpClient, StarBuilder $starBuilder)
    {
        $this->httpClient = $httpClient;
        $this->starBuilder = $starBuilder;
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        $starRaw = json_decode(
            $this->httpClient->request(
                'GET',
                'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY',
            )->getContent(),
            true
        );

        return $this->starBuilder->build($starRaw);
    }
}
