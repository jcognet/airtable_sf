<?php
declare(strict_types=1);

namespace App\Service\Builder\Qcm;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Qcm\Question;
use Carbon\Carbon;

class QuestionBuilder implements BuilderInterface
{
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
            usedDate: isset($data['fields']['Date d\'utilisation']) ? Carbon::parse($data['fields']['Date d\'utilisation']) : null
        );
    }
}
