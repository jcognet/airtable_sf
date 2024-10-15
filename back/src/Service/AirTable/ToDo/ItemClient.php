<?php
declare(strict_types=1);

namespace App\Service\AirTable\ToDo;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\Builder\ToDo\ItemBuilder;
use App\ValueObject\BlockInterface;
use App\ValueObject\ToDo\Item;

class ItemClient extends AbstractClient
{
    public function __construct(
        ItemBuilder $itemBuilder,
        string $airtableAppToDoId
    ) {
        parent::__construct($airtableAppToDoId, $itemBuilder);
    }

    /**
     * @param mixed $param
     * @return Item[]
     */
    public function findAll($param = []): array
    {
        if (!$param) {
            $param = [
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
            ];
        }

        return parent::findAll($param);
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
