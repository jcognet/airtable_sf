<?php
declare(strict_types=1);

namespace App\Service\Block\Question;

use App\Service\AirTable\Qcm\QuestionClient;
use App\Service\Block\BlockManagerInterface;
use App\Service\Import\Airtable\Qcm\Question\Lister;
use App\ValueObject\BlockInterface;

class QuestionManager implements BlockManagerInterface
{
    private const NB_RANDOM_ELT = 10;

    public function __construct(
        private readonly Lister $questionLister,
        private readonly QuestionClient $questionClient
    ) {
    }

    public function getContent(): ?BlockInterface
    {
        $list = $this->questionLister->list();

        if (!$list) {
            return null;
        }

        $oldestUsedQuestion = array_slice($list, 0, self::NB_RANDOM_ELT);
        $chosenQuestion = $oldestUsedQuestion[array_rand($oldestUsedQuestion)];
        $this->questionClient->updateLastUsed($chosenQuestion);

        return $chosenQuestion;
    }
}
