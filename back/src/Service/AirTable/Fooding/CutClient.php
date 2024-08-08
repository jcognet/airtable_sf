<?php
declare(strict_types=1);

namespace App\Service\AirTable\Fooding;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Fooding\CutBuilder;

class CutClient extends AbstractClient
{
    public function __construct(
        string $airtableAppFoodingId,
        CutBuilder $cutBuilder
    ) {
        parent::__construct($airtableAppFoodingId, $cutBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Coupe';
    }
}
