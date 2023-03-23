<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\InterestingTopic;
use App\ValueObject\Article\InterestingTopicList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class InterestingTopicListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): InterestingTopicList
    {
        $interestingTopics = [];
        $interestingTopicDenormalizer = new InterestingTopicDenormalizer();

        if (isset($data['articles'])) {
            foreach ($data['articles'] as $article) {
                $interestingTopics[] = $interestingTopicDenormalizer->denormalize($article, InterestingTopic::class, $format, $context);
            }
        }

        $data['articles'] = $interestingTopics;

        return (new ObjectNormalizer())->denormalize($data, $data['class'], $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === InterestingTopicList::class;
    }
}
