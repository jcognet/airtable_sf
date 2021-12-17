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

    private ?array $records = [];

    public function __construct(
        AirtableClient $airtableClient,
        BiereBuilder $biereBuilder,
        string $airtableAppBiereId
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppBiereId = $airtableAppBiereId;
        $this->biereBuilder = $biereBuilder;
    }

    public function fetchRandomData(array $param = null): BlockInterface
    {
        $keyResearch = md5(serialize($param));

        if (!isset($this->records[$keyResearch])) {
            $this->records[$keyResearch] = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/Bière', $this->airtableAppBiereId),
                    $param
                ),
                true
            )['records'];
        }

        $bieres = $this->records[$keyResearch];
        $key = array_rand($bieres);

        return $this->biereBuilder->build($bieres[$key]);
    }
}
