<?php
declare(strict_types=1);

namespace App\Service\AirTable\Qcm;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Qcm\QuestionBuilder;

class QuestionsClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppQcmId,
        QuestionBuilder $questionBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppQcmId, $questionBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Questions';
    }
}
