<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\Article;
use App\ValueObject\Article\ArticleList;
use App\ValueObject\Article\ArticleReadList;
use App\ValueObject\Article\ArticleSeeAgainList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AbstractArticleListDenormalizer implements DenormalizerInterface
{
    private const LIST_CLASS = [ArticleSeeAgainList::class, ArticleList::class, ArticleReadList::class];

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $articleDenormalizer = new ArticleDenormalizer();
        $articles = [];

        if (isset($data['articles'])) {
            foreach ($data['articles'] as $key => $article) {
                $articles[$key] = $articleDenormalizer->denormalize($article, Article::class, $format, $context);
            }
        }

        $data['articles'] = $articles;

        return (new ObjectNormalizer())->denormalize($data, $data['class'], $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return in_array($type, self::LIST_CLASS, true);
    }
}
