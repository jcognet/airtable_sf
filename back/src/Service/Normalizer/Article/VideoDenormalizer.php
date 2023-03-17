<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\Sujet;
use App\ValueObject\Article\Video;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class VideoDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (isset($data['sujets'])) {
            $sujets = [];
            foreach ($data['sujets'] as $sujet) {
                $sujets[] = new Sujet(
                    id: $sujet['id'],
                    label: $sujet['label']
                );
            }
            $data['sujets'] = $sujets;
        }

        $data['body'] = $data['content'];
        $data['addedAt'] = Carbon::parse($data['addedAt']);
        unset($data['content'], $data['class']);

        return new Video(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Video::class;
    }
}
