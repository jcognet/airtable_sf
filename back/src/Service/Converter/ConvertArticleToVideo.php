<?php
declare(strict_types=1);

namespace App\Service\Converter;

use App\ValueObject\Article\Article;
use App\ValueObject\Article\Video;
use App\ValueObject\BlockInterface;

class ConvertArticleToVideo implements ConverterInterface
{
    public function convert(BlockInterface $article): Video
    {
        if (!$article instanceof Article) {
            throw new \InvalidArgumentException(sprintf('Wrong type for ConvertArticleToVideo, got: %s, expected: %s', get_class($article), Article::class));
        }

        return new Video(
            $article->getTitle(),
            $article->getContent(),
            $article->getAddedAt(),
            $article->getSujets(),
            $article->getUrl()
        );
    }
}
