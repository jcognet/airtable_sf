<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\LuClient;
use App\Service\Block\BlockManagerInterface;
use App\Service\Converter\ConvertArticleToVideo;
use App\ValueObject\Article\Video;

class VideoBlockManager implements BlockManagerInterface
{
    private LuClient $luClient;
    private ConvertArticleToVideo $convertArticleToVideo;

    public function __construct(
        LuClient $luClient,
        ConvertArticleToVideo $convertArticleToVideo
    ) {
        $this->luClient = $luClient;
        $this->convertArticleToVideo = $convertArticleToVideo;
    }

    public function getContent(): ?Video
    {
        $article = $this->luClient->fetchRandomData([
            'filterByFormula' => '{Type} = "Vidéo"',
        ]);

        return $this->convertArticleToVideo->convert($article);
    }
}
