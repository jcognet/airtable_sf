<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\AirTable\AirtableClient;
use App\Service\Builder\Article\ArticleReadBuilder;
use App\ValueObject\BlockInterface;

class SeeAgainClient extends AbstractClient
{
    public function __construct(
        AirtableClient $airtableClient,
        string $airtableAppArticleId,
        ArticleReadBuilder $articleBuilder
    ) {
        parent::__construct($airtableClient, $airtableAppArticleId, $articleBuilder);
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        return parent::fetchRandomData($this->addFilterARevoir($param));
    }

    public function findAll(array $param = []): array
    {
        return parent::findAll($this->addFilterARevoir($param));
    }

    protected function getFetchUrl(): string
    {
        return 'Lu';
    }

    private function addFilterARevoir(array $param): array
    {
        if (!isset($param['filterByFormula'])) {
            $param['filterByFormula'] = '{A revoir} = 1';
        } else {
            if (str_contains((string) $param['filterByFormula'], '{A revoir} = 1')) {
                return $param;
            }

            $param['filterByFormula'] = sprintf(' AND (%s, {A revoir} = 1)', $param['filterByFormula']);
        }

        return $param;
    }
}
