<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Article\InterestingTopic;

class InterestingTopicBuilder implements BuilderInterface
{
    public function build(array $data): InterestingTopic
    {
        return new InterestingTopic(
            $data['fields']['Name'] ?? ''
        );
    }
}
