<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Exception\MethodNotUsableException;
use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Article\SujetBuilder;
use App\ValueObject\Article\Sujet;
use App\ValueObject\BlockInterface;

class SujetClient extends AbstractClient
{
    public function __construct(
        string $airtableAppArticleId,
        SujetBuilder $sujetBuilder
    ) {
        parent::__construct($airtableAppArticleId, $sujetBuilder);
    }

    public function fetchRandomData(array $param = []): ?BlockInterface
    {
        throw new MethodNotUsableException('Method fetchRandomData from %s it not callable.', self::class);
    }

    /**
     * @return Sujet[]
     */
    public function findAll(array $param = []): array
    {
        return parent::findAll([
            'fields' => ['Sujet'],
            'sort' => [
                [
                    'field' => 'Sujet',
                    'direction' => 'asc',
                ],
            ],
        ]);
    }

    protected function getFetchUrl(): string
    {
        return 'Sujets';
    }
}
