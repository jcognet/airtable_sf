<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\Article;
use App\ValueObject\Article\ArticleType;
use App\ValueObject\Article\Status;
use App\ValueObject\Article\Sujet;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ArticleDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $sujets = [];
        if (isset($data['sujets'])) {
            foreach ($data['sujets'] as $sujet) {
                $sujets[] = new Sujet(
                    id: $sujet['id'],
                    label: $sujet['label']
                );
            }
            $data['sujets'] = $sujets;
        }

        if (isset($data['status'])) {
            $data['status'] = new Status($data['status']['value']);
        }

        if (isset($data['articleType'])) {
            $data['articleType'] = new ArticleType($data['articleType']['value']);
        }

        $data['body'] = $data['content'];
        $data['addedAt'] = Carbon::parse($data['addedAt']);
        $data['hasConcept'] = $data['concept'];

        unset($data['content'], $data['class'], $data['concept']);

        return new Article(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Article::class;
    }
}
