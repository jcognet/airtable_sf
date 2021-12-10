<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Biere\BrasserieBuilder;
use App\ValueObject\Biere\Brasserie;

class BrasserieClient
{
    private AirtableClient $airtableClient;
    private string $airtableAppBiereId;
    private BrasserieBuilder $brasserieBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        BrasserieBuilder $brasserieBuilder,
        string $airtableAppBiereId
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppBiereId = $airtableAppBiereId;
        $this->brasserieBuilder = $brasserieBuilder;
    }

    /**
     * @return Brasserie[]
     */
    public function findAll(): array
    {
        $brasseries = [];

        $response = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/Brasserie', $this->airtableAppBiereId),
                [
                    'field' => ['Commentaires', 'URL', 'Name', 'Site', 'Moyenne des binches'],
                ],
            ),
            true
        );

        foreach ($response['records'] as $rawBrasserie) {
            $brasseries[$rawBrasserie['id']] = $this->brasserieBuilder->build($rawBrasserie);
        }

        return $brasseries;
    }
}
