<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Biere\BiereTypeBuilder;
use App\ValueObject\Biere\BiereType;
use App\ValueObject\Biere\Brasserie;

class BiereTypeClient
{
    private AirtableClient $airtableClient;
    private string $airtableAppBiereId;
    private BiereTypeBuilder $biereTypeBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        BiereTypeBuilder $biereTypeBuilder,
        string $airtableAppBiereId
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppBiereId = $airtableAppBiereId;
        $this->biereTypeBuilder = $biereTypeBuilder;
    }

    /**
     * @return BiereType[]
     */
    public function findAll(): array
    {
        $biereTypes = [];

        $response = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/Type de bières', $this->airtableAppBiereId)
            ),
            true
        );

        foreach ($response['records'] as $rawData) {
            $biereTypes[$rawData['id']] = $this->biereTypeBuilder->build($rawData);
        }

        return $biereTypes;
    }
}
