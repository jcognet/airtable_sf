<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\StarBuilder;
use App\ValueObject\BlockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StarRepository implements RandomImageRepositoryInterface
{
    public function __construct(private readonly HttpClientInterface $httpClient, private readonly StarBuilder $starBuilder) {}

    public function fetchRandomData(array $param = []): BlockInterface
    {
        $starRaw = json_decode(
            $this->httpClient->request(
                'GET',
                'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY',
            )->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return $this->starBuilder->build($starRaw);
    }
}
