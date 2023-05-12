<?php
declare(strict_types=1);

namespace App\Service\Page;

use App\Service\Block\BlockFinder;
use App\Service\Import\Airtable\Qcm\Question\Lister;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\Newspaper;
use App\ValueObject\Qcm\Question;

class QuestionFetcher
{
    public function __construct(
        private readonly Lister $questionLister,
        private readonly BlockFinder $blockFinder
    ) {
    }

    public function fetch(Newspaper $newspaper): ?Question
    {
        $block = $this->blockFinder->findInNewspaper(
            $newspaper,
            BlockType::QUIZ
        );

        if ($block !== null) {
            return $block[0];
        }

        $questions = $this->questionLister->list();

        if ($questions === null) {
            return null;
        }

        return $questions[array_rand($questions)];
    }
}
