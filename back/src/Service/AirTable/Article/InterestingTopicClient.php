<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Article\InterestingTopicBuilder;

class InterestingTopicClient extends AbstractClient
{
    public function __construct(
        string $airtableAppArticleId,
        InterestingTopicBuilder $interestingTopicBuilder
    ) {
        parent::__construct($airtableAppArticleId, $interestingTopicBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'A creuser';
    }
}
