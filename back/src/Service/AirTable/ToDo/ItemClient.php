<?php
declare(strict_types=1);

namespace App\Service\AirTable\ToDo;

use App\Service\AirTable\AirtableClient;
use App\Service\Builder\ToDo\ItemBuilder;
use App\ValueObject\ToDo\Item;

class ItemClient
{
    private AirtableClient $airtableClient;
    private string $airtableAppToDoId;
    private ItemBuilder $itemBuilder;

    private ?array $records = [];

    public function __construct(
        AirtableClient $airtableClient,
        ItemBuilder $itemBuilder,
        string $airtableAppToDoId
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppToDoId = $airtableAppToDoId;
        $this->itemBuilder = $itemBuilder;
    }

    /**
     * @return Item[]
     */
    public function findAll(): array
    {
        $toDos = [];

        $response = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/To do', $this->airtableAppToDoId),
                [
                    'filterByFormula' => 'OR({Etat} ="Ready to go",{Etat} ="In progress")',
                    'sort' => [
                        [
                            'field' => 'Echéance',
                            'direction' => 'asc',
                        ],
                    ],
                ]
            ),
            true
        );

        foreach ($response['records'] as $rawToDo) {
            $toDos[$rawToDo['id']] = $this->itemBuilder->build($rawToDo);
        }

        return $toDos;
    }
}
