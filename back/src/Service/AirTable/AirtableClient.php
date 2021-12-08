<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AirtableClient
{
    private HttpClientInterface $airtableClient;

    public function __construct(HttpClientInterface $airtableClient)
    {
        $this->airtableClient = $airtableClient;
    }

    public function request(string $verb, string $url, array $param = []): string
    {
        return $this->airtableClient->request($verb, $url)->getContent();
    }
}
