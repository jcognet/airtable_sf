<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Service\AirTable\AirtableClient;
use App\Service\AirTable\FetchDataInterface;
use App\Service\Builder\Biere\BiereBuilder;
use App\ValueObject\BlockInterface;

class BiereClient implements FetchDataInterface
{
    private AirtableClient $airtableClient;
    private string $airtableAppBiereId;
    private BiereBuilder $biereBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        BiereBuilder $biereBuilder,
        string $airtableAppBiereId
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppBiereId = $airtableAppBiereId;
        $this->biereBuilder = $biereBuilder;
    }

    public function fetchData(array $param = null): BlockInterface
    {
        $records = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/Bière', $this->airtableAppBiereId),
                [
                    'filterByFormula' => '{Note} > 4',
                ],
            ),
            true
        );

        $bieres = $records['records'];
        $key = array_rand($bieres);

        return $this->biereBuilder->build($bieres[$key]);
    }
}
