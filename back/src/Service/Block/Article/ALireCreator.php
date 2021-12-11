<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\ALireClient;
use App\Service\Block\CreatorInterface;
use App\ValueObject\Article\ArticleList;
use App\ValueObject\BlockInterface;

class ALireCreator implements CreatorInterface
{
    private ALireClient $ALireClient;

    public function __construct(ALireClient $ALireClient)
    {
        $this->ALireClient = $ALireClient;
    }

    public function getContent(): BlockInterface
    {
        $articles = [];

        $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => '{Status} = "In progress"']);
        $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => '{Status} = "In progress"']);
        $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => '{Status} = "Todo"']);
        $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => '{Status} = "Todo"']);
        $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => '{Status} = "Todo"']);

        return new ArticleList(
            'Articles à lire',
            $articles
        );
    }
}
