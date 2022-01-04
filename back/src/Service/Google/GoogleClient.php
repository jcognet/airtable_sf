<?php
declare(strict_types=1);

namespace App\Service\Google;

class GoogleClient
{
    private string $googleCredentialFile;

    public function __construct(string $googleCredentialFile)
    {
        $this->googleCredentialFile = $googleCredentialFile;
    }

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
