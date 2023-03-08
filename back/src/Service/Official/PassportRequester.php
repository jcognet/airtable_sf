<?php

namespace App\Service\Official;

use Carbon\Carbon;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PassportRequester
{
    public function __construct(
        private readonly HttpClientInterface $passportClient,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function request(): bool
    {
        $response = $this->passportClient->request('GET', $this->getUrl());
        $this->logger->info(sprintf('Connection to %s', $response->getInfo()['url']));

        dd($response->getContent());
    }

    private function getUrl(): string
    {
        $now = Carbon::now();

        return sprintf(
            '#date-de-debut=%s&date-de-fin=%s&distance=20&latitude=48.863367&longitude=2.397152&address=Paris 20e Arrondissement 75020&nombre-de-personnes=1&motif=CNI-PASSPORT',
            $now->format('Y-m-d'),
            $now->addMonths(2)->format('Y-m-d')
        );
    }
}
