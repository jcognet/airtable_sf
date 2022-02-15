<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\ALireClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\Article\ArticleList;
use App\ValueObject\Article\Status;
use App\ValueObject\BlockInterface;

class ArticleListALireBlockManager implements BlockManagerInterface
{
    private ALireClient $ALireClient;

    public function __construct(ALireClient $ALireClient)
    {
        $this->ALireClient = $ALireClient;
    }

    public function getContent(): ?BlockInterface
    {
        $articles = [];

        $randInProgress = random_int(2, 6);

        for ($i = 0; $i < $randInProgress; ++$i) {
            $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => sprintf('{Status} = "%s"', Status::AT_IN_PROGRESS)]);
        }

        $nbArticles = random_int(1, 6);

        for ($i = 0; $i < $nbArticles; ++$i) {
            $articles[] = $this->ALireClient->fetchRandomData(['filterByFormula' => sprintf('{Status} = "%s"', Status::AT_TO_DO)]);
        }

        $articles = array_filter($articles);
        if (count($articles) === 0) {
            return null;
        }

        return new ArticleList(
            'Articles à lire',
            $articles,
            $this->ALireClient->getNbItems()
        );
    }
}
