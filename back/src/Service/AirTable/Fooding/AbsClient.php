<?php
declare(strict_types=1);

namespace App\Service\AirTable\Fooding;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Fooding\AbsBuilder;

class AbsClient extends AbstractClient
{
    public function __construct(
        string $airtableAppFoodingId,
        AbsBuilder $absBuilder
    ) {
        parent::__construct($airtableAppFoodingId, $absBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Abdo';
    }
}
