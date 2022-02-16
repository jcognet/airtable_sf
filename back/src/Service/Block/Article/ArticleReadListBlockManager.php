<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\LuClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\Article\ArticleReadList;
use App\ValueObject\BlockInterface;

class ArticleReadListBlockManager implements BlockManagerInterface
{
    private const NB_ARTICLE = 3;

    private LuClient $luClient;

    public function __construct(LuClient $luClient)
    {
        $this->luClient = $luClient;
    }

    public function getContent(): ?BlockInterface
    {
        $articles = [];

        for ($i = 0; $i < self::NB_ARTICLE; ++$i) {
            $articles[] = $this->luClient->fetchRandomData();
        }

        $articles = array_filter($articles);
        if (count($articles) === 0) {
            return null;
        }

        return new ArticleReadList(
            'Articles à relire',
            $articles,
            $this->luClient->getNbItems()
        );
    }
}
