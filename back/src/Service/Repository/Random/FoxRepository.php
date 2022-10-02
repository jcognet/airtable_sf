<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\FoxBuilder;
use App\ValueObject\BlockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FoxRepository implements RandomImageRepositoryInterface
{
    public function __construct(private readonly HttpClientInterface $httpClient, private readonly FoxBuilder $foxBuilder)
    {
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        $foxRaw = json_decode(
            $this->httpClient->request(
                'GET',
                'https://randomfox.ca/floof/',
            )->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return $this->foxBuilder->build($foxRaw);
    }
}
