<?php
declare(strict_types=1);

namespace App\Service\Builder\Qcm;

use App\Service\AirTable\UrlBuilder;
use App\Service\Builder\BuilderInterface;
use App\ValueObject\Qcm\Question;
use Carbon\Carbon;

class QuestionBuilder implements BuilderInterface
{
    private const TABLE_URL = 'tblVVWYtU54qbG9zL';

    public function __construct(
        private readonly UrlBuilder $urlBuilder,
        private readonly string $airtableAppQcmId
    ) {
    }

    public function build(array $data): Question
    {
        return new Question(
            id: $data['id'],
            question: $data['fields']['Question'],
            answer: $data['fields']['Bonne réponse'],
            wrongAnswer1: $data['fields']['Mauvaise réponse 1'] ?? null,
            wrongAnswer2: $data['fields']['Mauvaise réponse 2'] ?? null,
            wrongAnswer3: $data['fields']['Mauvaise réponse 3'] ?? null,
            explanation: $data['fields']['Explication'] ?? null,
            url: $data['fields']['URL détail'] ?? null,
            usedDate: isset($data['fields']['Date d\'utilisation']) ? Carbon::parse($data['fields']['Date d\'utilisation']) : null,
            airTableUrl: $this->urlBuilder->build(
                $this->airtableAppQcmId,
                self::TABLE_URL,
                $this->getViewUrl(),
                $data['id']
            )
        );
    }

    public function unBuild(Question $question): array
    {
        return [
            'id' => $question->getId(),
            'fields' => [
                'Date d\'utilisation' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
    }

    private function getViewUrl(): string
    {
        return 'viw5t0rcjSWFHP9X6';
    }
}
