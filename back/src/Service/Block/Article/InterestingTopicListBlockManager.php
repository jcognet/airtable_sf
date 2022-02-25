<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\InterestingTopicClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\Article\InterestingTopicList;
use App\ValueObject\BlockInterface;

class InterestingTopicListBlockManager implements BlockManagerInterface
{
    private InterestingTopicClient $interestingTopicClient;

    public function __construct(InterestingTopicClient $interestingTopicClient)
    {
        $this->interestingTopicClient = $interestingTopicClient;
    }

    public function getContent(): ?BlockInterface
    {
        return new InterestingTopicList(
            'Sujets à creuser',
            $this->interestingTopicClient->findAll(),
            $this->interestingTopicClient->getNbItems()
        );
    }
}
