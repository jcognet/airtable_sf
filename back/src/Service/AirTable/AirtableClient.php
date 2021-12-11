<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class AirtableClient
{
    private HttpClientInterface $airtableClient;

    public function __construct(HttpClientInterface $airtableClient)
    {
        $this->airtableClient = $airtableClient;
    }

    public function request(string $verb, string $url, ?array $parameters = []): string
    {
        $options = [];

        if ($parameters !== null && count($parameters) > 0) {
            $options = ['query' => $parameters];
        }

        return $this->airtableClient->request($verb, $url, $options)->getContent();
    }
}
