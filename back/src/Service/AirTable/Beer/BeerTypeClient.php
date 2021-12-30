<?php
declare(strict_types=1);

namespace App\Service\AirTable\Beer;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Beer\BeerTypeBuilder;
use App\ValueObject\Beer\BeerType;
use App\ValueObject\BlockInterface;

class BeerTypeClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppBiereId,
        BeerTypeBuilder $beerTypeBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $beerTypeBuilder);
    }

    /**
     * @return BeerType[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        throw new MethodNotUsableException('Method fetchRandomData from %s it not callable.', self::class);
    }

    protected function getFetchUrl(): string
    {
        return 'Type de bières';
    }
}
