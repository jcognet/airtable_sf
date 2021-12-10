<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AirtableClient;
use App\Service\AirTable\FetchDataInterface;
use App\Service\Builder\Article\ArticleBuilder;
use App\ValueObject\Article\ArticleList;
use App\ValueObject\BlockInterface;

class ALireClient implements FetchDataInterface
{
    private AirtableClient $airtableClient;
    private string $airtableAppArticleId;
    private ArticleBuilder $articleBuilder;

    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleBuilder $articleBuilder
    ) {
        $this->airtableClient = $airtableClient;
        $this->airtableAppArticleId = $airtableAppArticleId;
        $this->articleBuilder = $articleBuilder;
    }

    public function fetchData(array $param = []): BlockInterface
    {
        $articles = [];

        $records = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/A lire', $this->airtableAppArticleId),
                [
                    'filterByFormula' => '{Status} = "In progress"',
                ],
            ),
            true
        );

        $articlesInProgress = $records['records'];
        if (count($articlesInProgress) > 0) {
            $articles[] = $this->articleBuilder->build($articlesInProgress[array_rand($articlesInProgress)]);
            $articles[] = $this->articleBuilder->build($articlesInProgress[array_rand($articlesInProgress)]);
        }

        $records = json_decode(
            $this->airtableClient->request(
                'GET',
                sprintf('%s/A lire', $this->airtableAppArticleId),
                [
                    'filterByFormula' => '{Status} = "Todo"',
                ],
            ),
            true
        );

        $articlesRead = $records['records'];

        $articles[] = $this->articleBuilder->build($articlesRead[array_rand($articlesRead)]);
        $articles[] = $this->articleBuilder->build($articlesRead[array_rand($articlesRead)]);
        $articles[] = $this->articleBuilder->build($articlesRead[array_rand($articlesRead)]);

        return new ArticleList(
            'Articles à lire',
            $articles
        );
    }
}
