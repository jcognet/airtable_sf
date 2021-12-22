<?php
declare(strict_types=1);

namespace App\Service\AirTable\Biere;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Biere\BiereTypeBuilder;
use App\ValueObject\Biere\BiereType;
use App\ValueObject\BlockInterface;

class BiereTypeClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppBiereId,
        BiereTypeBuilder $biereTypeBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppBiereId, $biereTypeBuilder);
    }

    /**
     * @return BiereType[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        throw new MethodNotUsableException('Method fetchRandomData from %s it not callable.', self::class);
    }

    protected function getFetchUrl(): string
    {
        return 'Type de bières';
    }
}
