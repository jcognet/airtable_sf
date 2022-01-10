<?php
declare(strict_types=1);

namespace App\Service\AirTable\ToDo;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\ToDo\ItemBuilder;
use App\ValueObject\BlockInterface;
use App\ValueObject\ToDo\Item;

class ItemClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppToDoId,
        ItemBuilder $itemBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppToDoId, $itemBuilder);
    }

    /**
     * @param mixed $param
     * @return Item[]
     */
    public function findAll($param = []): array
    {
        return parent::findAll([
            'filterByFormula' => 'OR({Etat} ="Ready to go",{Etat} ="In progress")',
            'sort' => [
                [
                    'field' => 'Echéance',
                    'direction' => 'asc',
                ],
                [
                    'field' => 'A faire',
                    'direction' => 'asc',
                ],
            ],
        ]);
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        throw new MethodNotUsableException('Method fetchRandomData from %s it not callable.', self::class);
    }

    protected function getFetchUrl(): string
    {
        return 'To do';
    }
}
