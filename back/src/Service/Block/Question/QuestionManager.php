<?php
declare(strict_types=1);

namespace App\Service\Block\Question;

use App\Service\Block\BlockManagerInterface;
use App\Service\Import\Airtable\Qcm\Question\QuestionLister;
use App\ValueObject\BlockInterface;

class QuestionManager implements BlockManagerInterface
{
    public function __construct(private readonly QuestionLister $questionLister)
    {
    }

    public function getContent(): ?BlockInterface
    {
        $list = $this->questionLister->list();

        return $list[array_rand($list)];
    }
}
