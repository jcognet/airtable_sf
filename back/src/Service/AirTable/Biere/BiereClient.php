<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Biere\BiereBuilder;
use App\ValueObject\Biere\Biere;

class BiereClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        BiereBuilder $biereBuilder,
        string $airtableAppBiereId
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $biereBuilder);
    }

    public function fetchRandomData(array $param = []): Biere
    {
        return parent::fetchRandomData($param);
    }

    /**
     * @return Biere[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    protected function getFetchUrl(): string
    {
        return 'Bière';
    }
}
