<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Article\InterestingTopicBuilder;

class InterestingTopicClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        InterestingTopicBuilder $interestingTopicBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppArticleId, $interestingTopicBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'A creuser';
    }
}
