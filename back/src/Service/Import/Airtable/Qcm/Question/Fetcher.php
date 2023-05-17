<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\ValueObject\Qcm\Question;

class Fetcher
{
    public function __construct(
        private readonly Lister $questionLister
    ) {
    }

    public function fetch(string $id): ?Question
    {
        $list = $this->questionLister->list();
        
        if ($list === null) {
            return null;
        }

        foreach ($list as $question) {
            if ($question->getId() === $id) {
                return $question;
            }
        }

        return null;
    }
}
