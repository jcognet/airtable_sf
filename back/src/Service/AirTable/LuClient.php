<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\ArticleBuilder;
use App\ValueObject\BlockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LuClient implements FetchDataInterface
{
    private AirtableClient $airtableClient;
    private string $airtableAppArticleId;
    private ArticleBuilder $articleBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleBuilder $articleBuilder
    )
    {
        $this->airtableClient = $airtableClient;
        $this->airtableAppArticleId = $airtableAppArticleId;
        $this->articleBuilder = $articleBuilder;
    }

    public function fetchData(): BlockInterface
    {
        return $this->articleBuilder->build(
            json_decode($this->airtableClient->request('GET', sprintf('%s/Lu', $this->airtableAppArticleId)), true)
        );
    }
}
