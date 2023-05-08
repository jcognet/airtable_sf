<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Import\Airtable\Qcm\Question\QuestionLister;
use App\ValueObject\Newspaper;
use App\ValueObject\Qcm\Question;

class QuestionFetcher
{
    public function __construct(
        private readonly QuestionLister $questionLister
    ) {
    }

    public function fetch(Newspaper $newspaper): ?Question
    {
        // TODO : seek bloc
        $questions = $this->questionLister->list();

        if ($questions === null) {
            return null;
        }

        return $questions[array_rand($questions)];
    }
}
