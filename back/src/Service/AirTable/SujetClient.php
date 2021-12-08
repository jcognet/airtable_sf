<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\SujetBuilder;
use App\ValueObject\Sujet;

class SujetClient
{
    private AirtableClient $airtableClient;
    private string $airtableAppArticleId;
    private SujetBuilder $sujetBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        SujetBuilder $sujetBuilder
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppArticleId = $airtableAppArticleId;
        $this->sujetBuilder = $sujetBuilder;
    }

    /**
     * @return Sujet[]
     */
    public function fetchData(): array
    {
        $sujets = [];
        $response = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/Sujets', $this->airtableAppArticleId),
                [
                    'fields' => ['Sujet'],
                    'sort' => [
                        [
                            'field' => 'Sujet',
                            'direction' => 'asc',
                        ],
                    ],
                ]
            ),
            true
        );

        foreach ($response['records'] as $rawSujet) {
            $sujets[$rawSujet['id']] = $this->sujetBuilder->build($rawSujet);
        }

        return $sujets;
    }
}
