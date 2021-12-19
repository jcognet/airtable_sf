<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Biere\BrasserieBuilder;
use App\ValueObject\Biere\Brasserie;
use App\ValueObject\BlockInterface;

class BrasserieClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppBiereId,
        BrasserieBuilder $brasserieBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $brasserieBuilder);
    }

    /**
     * @return Brasserie[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll([
            'field' => ['Commentaires', 'URL', 'Name', 'Site', 'Moyenne des binches'],
        ]);
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        throw new MethodNotUsableException('Method fetchRandomData from %s it not callable.', self::class);
    }

    protected function getFetchUrl(): string
    {
        return 'Brasserie';
    }
}
