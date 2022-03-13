<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\CurrencyBuilder;
use App\ValueObject\Random\Currency;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyRepository
{
    private HttpClientInterface $currencyClient;
    private CurrencyBuilder $currencyBuilder;

    public function __construct(
        HttpClientInterface $currencyClient,
        CurrencyBuilder $currencyBuilder
    ) {
        $this->currencyClient = $currencyClient;
        $this->currencyBuilder = $currencyBuilder;
    }

    /**
     * @return Currency[]
     */
    public function getCurrencies(): array
    {
        $content = json_decode(
            $this->currencyClient->request(
                'GET',
                'latest',
                [
                    'query' => [
                        'base' => 'EUR',
                        'symbols' => 'JPY, NOK, CAD, USD, GBP',
                    ],
                ]
            )
                ->getContent(),
            true
        );

        return array_map(
            fn ($key, $value) => $this->currencyBuilder->build(
                [
                    'symbol' => $key,
                    'value' => $value,
                    'date' => $content['date'],
                ]
            ),
            array_keys($content['rates']),
            $content['rates']
        );
    }
}
