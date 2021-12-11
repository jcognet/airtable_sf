<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\AirTable\FetchDataInterface;
use App\Service\Builder\Random\FoxBuilder;
use App\ValueObject\BlockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FoxRepository implements FetchDataInterface
{
    private HttpClientInterface $httpClient;
    private FoxBuilder $foxBuilder;

    public function __construct(HttpClientInterface $httpClient, FoxBuilder $foxBuilder)
    {
        $this->httpClient = $httpClient;
        $this->foxBuilder = $foxBuilder;
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        $foxRaw = json_decode(
            $this->httpClient->request(
                'GET',
                'https://randomfox.ca/floof/',
            )->getContent(),
            true
        );

        return $this->foxBuilder->build($foxRaw);
    }
}
