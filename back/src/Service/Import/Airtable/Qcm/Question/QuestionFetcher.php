<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\ValueObject\Qcm\Question;

class QuestionFetcher
{
    public function __construct(
        private readonly QuestionLister $questionLister
    ) {
    }

    public function fetch(string $id): ?Question
    {
        foreach ($this->questionLister->list() as $question) {
            if ($question->getId() === $id) {
                return $question;
            }
        }

        return null;
    }
}
