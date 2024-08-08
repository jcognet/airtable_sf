<?php
declare(strict_types=1);

namespace App\Service\AirTable\Fooding;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Fooding\QiBuilder;

class QiClient extends AbstractClient
{
    public function __construct(
        string $airtableAppFoodingId,
        QiBuilder $qiBuilder
    ) {
        parent::__construct($airtableAppFoodingId, $qiBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'QI';
    }
}
