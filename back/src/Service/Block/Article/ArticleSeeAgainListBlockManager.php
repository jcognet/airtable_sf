<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\SeeAgainClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\Article\ArticleSeeAgainList;
use App\ValueObject\BlockInterface;

class ArticleSeeAgainListBlockManager implements BlockManagerInterface
{
    private const NB_ARTICLE = 2;

    public function __construct(private readonly SeeAgainClient $seeAgainClient)
    {
    }

    public function getContent(): ?BlockInterface
    {
        $articles = [];

        for ($i = 0; $i < self::NB_ARTICLE; ++$i) {
            $articles[] = $this->seeAgainClient->fetchRandomData();
        }

        $articles = array_filter($articles);
        if (count($articles) === 0) {
            return null;
        }

        return new ArticleSeeAgainList(
            'Articles à revoir',
            $articles,
            $this->seeAgainClient->getNbItems()
        );
    }
}
