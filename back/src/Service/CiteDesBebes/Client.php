<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    public function __construct(private readonly HttpClientInterface $citeDesBebesClient) {}

    public function fetch(): array
    {
        return json_decode(
            $this->citeDesBebesClient->request('GET', 'shows.json?lang=fr')->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        )['data']['shows']['data'];
    }
}
