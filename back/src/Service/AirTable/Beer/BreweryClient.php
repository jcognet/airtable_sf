<?php
declare(strict_types=1);

namespace App\Service\AirTable\Beer;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Beer\BreweryBuilder;
use App\ValueObject\Beer\Brewery;
use App\ValueObject\BlockInterface;

class BreweryClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppBiereId,
        BreweryBuilder $brasserieBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $brasserieBuilder);
    }

    /**
     * @return Brewery[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll([
            'field' => ['Commentaires', 'URL', 'Name', 'Site', 'Moyenne des binches'],
        ]);
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        throw new MethodNotUsableException('Method fetchRandomData from %s it not callable.', self::class);
    }

    protected function getFetchUrl(): string
    {
        return 'Brasserie';
    }
}
