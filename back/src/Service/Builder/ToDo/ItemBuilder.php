<?php
declare(strict_types=1);

namespace App\Service\Builder\ToDo;

use App\Service\AirTable\UrlBuilder;
use App\Service\Builder\BuilderInterface;
use App\ValueObject\ToDo\Item;
use Carbon\Carbon;

class ItemBuilder implements BuilderInterface
{
    private const TABLE_URL = 'tblnL05ciSOw0o6UC';
    private const TABLE_VIEW_ID = 'viwdjmPKllWToTNFL';

    public function __construct(
        private readonly UrlBuilder $urlBuilder,
        private readonly string $airtableAppToDoId
    ) {}

    public function build(array $data)
    {
        return new Item(
            $data['id'],
            Carbon::parse($data['createdTime']),
            $data['fields']['A faire'] ?? null,
            $data['fields']['Notes'] ?? null,
            $data['fields']['Etat'] ?? null,
            isset($data['fields']['Echéance']) ? Carbon::parse($data['fields']['Echéance']) : null,
            $data['fields']['Catégorie'] ?? null,
            isset($data['fields']['Prioritaire']),
            airTableUrl: $this->urlBuilder->build(
                $this->airtableAppToDoId,
                self::TABLE_URL,
                self::TABLE_VIEW_ID,
                $data['id']
            ),
            complexity: $data['fields']['Complexité'] ?? null,
        );
    }
}
