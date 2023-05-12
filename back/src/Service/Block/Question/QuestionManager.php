<?php
declare(strict_types=1);

namespace App\Service\Block\Question;

use App\Service\AirTable\Qcm\QuestionsClient;
use App\Service\Block\BlockManagerInterface;
use App\Service\Import\Airtable\Qcm\Question\QuestionLister;
use App\ValueObject\BlockInterface;

class QuestionManager implements BlockManagerInterface
{
    private const NB_RANDOM_ELT = 10;

    public function __construct(
        private readonly QuestionLister $questionLister,
        private readonly QuestionsClient $questionsClient
    ) {
    }

    public function getContent(): ?BlockInterface
    {
        $list = $this->questionLister->list();
        $oldestUsedQuestion = array_slice($list, 0, self::NB_RANDOM_ELT);
        $chosenQuestion = $oldestUsedQuestion[array_rand($oldestUsedQuestion)];
        $this->questionsClient->update($chosenQuestion);

        return $chosenQuestion;
    }
}
