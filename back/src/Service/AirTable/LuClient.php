<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Service\Builder\ArticleBuilder;
use App\ValueObject\BlockInterface;

class LuClient implements FetchDataInterface
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

    public function fetchData(): BlockInterface
    {
        $records = json_decode(
            $this->airtableClient->request(
            'GET',
            sprintf('%s/Lu', $this->airtableAppArticleId),
            [
                'filterByFormula' => '{Type} = "Texte"',
            ],
        ),
            true
        );

        $articles = $records['records'];
        $key = array_rand($articles);

        return $this->articleBuilder->build($articles[$key]);
    }
}
