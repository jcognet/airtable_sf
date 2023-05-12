<?php
declare(strict_types=1);

namespace App\Service\AirTable\Qcm;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Qcm\QuestionBuilder;
use App\ValueObject\Qcm\Question;

class QuestionClient extends AbstractClient
{
    private readonly QuestionBuilder $questionBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppQcmId,
        QuestionBuilder $questionBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppQcmId, $questionBuilder);
        $this->questionBuilder = $questionBuilder;
    }

    public function update(Question $question): void
    {
        $this->airtableClient->rawRequest(
            'PATCH',
            sprintf('%s/%s', $this->airtableAppId, $this->getFetchUrl()),
            [
                'json' => [
                    'records' => [
                        $this->questionBuilder->unBuild($question),
                    ],
                ],
            ],
        );
    }

    protected function getFetchUrl(): string
    {
        return 'Questions';
    }
}
