<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class AirtableClient
{
    public function __construct(private readonly HttpClientInterface $airtableClient)
    {
    }

    public function request(string $verb, string $url, ?array $parameters = []): string
    {
        $options = [];

        if ($parameters !== null && count($parameters) > 0) {
            $options = ['query' => $parameters];
        }

        return $this->airtableClient->request($verb, $url, $options)->getContent();
    }

    public function rawRequest(string $verb, string $url, ?array $parameters = []): string
    {
        return $this->airtableClient->request($verb, $url, $parameters)->getContent();
    }
}
