<?php
declare(strict_types=1);

namespace App\Service\AirTable\Article;

use App\Service\AirTable\AbstractClient;
use App\Service\Builder\Article\ConceptBuilder;

class ConceptClient extends AbstractClient
{
    public function __construct(
        string $airtableAppArticleId,
        ConceptBuilder $conceptBuilder
    ) {
        parent::__construct($airtableAppArticleId, $conceptBuilder);
    }

    protected function getFetchUrl(): string
    {
        return 'Concept';
    }
}
