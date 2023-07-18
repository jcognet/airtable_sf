<?php
declare(strict_types=1);

namespace App\Service\AirTable\Qcm;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Qcm\QuestionBuilder;

class QuestionClient extends AbstractClient
{
    private readonly QuestionBuilder $questionBuilder;

    public function __construct(
        string $airtableAppQcmId,
        QuestionBuilder $questionBuilder
    ) {
        parent::__construct($airtableAppQcmId, $questionBuilder);
        $this->questionBuilder = $questionBuilder;
    }

    protected function getFetchUrl(): string
    {
        return 'Questions';
    }
}
