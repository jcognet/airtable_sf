<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AirtableClient;
use App\Service\AirTable\FetchDataInterface;
use App\Service\Builder\Article\ArticleBuilder;
use App\ValueObject\BlockInterface;

class LuClient implements FetchDataInterface
{
    private AirtableClient $airtableClient;
    private string $airtableAppArticleId;
    private ArticleBuilder $articleBuilder;

    private ?array $records = [];

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleBuilder $articleBuilder
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppArticleId = $airtableAppArticleId;
        $this->articleBuilder = $articleBuilder;
    }

    public function fetchRandomData(array $param = null): BlockInterface
    {
        $keyResearch = md5(serialize($param));

        if (!isset($this->records[$keyResearch])) {
            $this->records[$keyResearch] = json_decode(
                $this->airtableClient->request(
                    'GET',
                    sprintf('%s/Lu', $this->airtableAppArticleId),
                    $param,
                ),
                true
            );
        }

        $articles = $this->records[$keyResearch]['records'];
        $key = array_rand($articles);

        return $this->articleBuilder->build($articles[$key]);
    }
}
