<?php
declare(strict_types=1);

namespace App\Service\Repository\Official;

use Carbon\Carbon;

class PassportRepository
{
    public function __construct(
        private readonly string $passportBaseUrl
    )
    {
    }

    public function getUrl(): string
    {
        $now = Carbon::now();

        return sprintf(
            '%s#date-de-debut=%s&date-de-fin=%s&distance=20&latitude=48.863367&longitude=2.397152&address=Paris 20e Arrondissement 75020&nombre-de-personnes=1&motif=CNI-PASSPORT',
            $this->passportBaseUrl,
            $now->format('Y-m-d'),
            $now->addMonths(2)->format('Y-m-d')
        );
    }
}
