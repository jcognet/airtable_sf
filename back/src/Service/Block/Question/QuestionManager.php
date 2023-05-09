<?php
declare(strict_types=1);

namespace App\Service\Block\Question;

use App\Service\AirTable\Qcm\QuestionsClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class QuestionManager implements BlockManagerInterface
{
    public function __construct(private readonly QuestionsClient $questionsClient)
    {
    }

    public function getContent(): ?BlockInterface
    {
        return $this->questionsClient->fetchRandomData();
    }
}
