<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\CurrencyBuilder;
use App\ValueObject\Random\Currency;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyRepository
{
    public function __construct(private readonly HttpClientInterface $currencyClient, private readonly CurrencyBuilder $currencyBuilder) {}

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
            true,
            512,
            JSON_THROW_ON_ERROR
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
