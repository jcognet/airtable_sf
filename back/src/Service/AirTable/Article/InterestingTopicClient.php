<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Article\InterestingTopicBuilder;
use App\ValueObject\Article\InterestingTopic;

class InterestingTopicClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        InterestingTopicBuilder $interestingTopicBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppArticleId, $interestingTopicBuilder);
    }

    public function fetchRandomData(array $param = []): ?InterestingTopic
    {
        return parent::fetchRandomData($param);
    }

    /**
     * @return InterestingTopic[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll($param);
    }

    protected function getFetchUrl(): string
    {
        return 'A creuser';
    }
}
