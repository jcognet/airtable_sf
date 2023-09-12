<?php
declare(strict_types=1);

namespace App\Service\Google;

class GoogleClient
{
    public function __construct(private readonly string $googleCredentialFile) {}

    public function getCurrentSheets(): \Google_Service_Sheets
    {
        $client = new \Google_Client();
        $client->setApplicationName('Fun Effect');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($this->googleCredentialFile);

        return new \Google_Service_Sheets($client);
    }
}
