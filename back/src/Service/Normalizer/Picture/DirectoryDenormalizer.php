<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Picture;

use App\ValueObject\Picture\Directory;
use App\ValueObject\Picture\Picture;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DirectoryDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Directory
    {
        if ($data['subDirectories']) {
            $subDirectories = [];

            foreach ($data['subDirectories'] as $subDirectory) {
                $subDirectories[] = $this->denormalize($subDirectory, $type, $format, $context);
            }

            $data['subDirectories'] = $subDirectories;
        }

        if ($data['pictures']) {
            $pictures = [];
            $pictureDenormalizer = new PictureDenormalizer();

            foreach ($data['pictures'] as $picture) {
                $pictures[] = $pictureDenormalizer->denormalize($picture, Picture::class, $format, $context);
            }

            $data['pictures'] = $pictures;
        }

        unset($data['title'], $data['content'], $data['type'], $data['managerTypeValue'], $data['managerType'], $data['class']);

        return new Directory(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Directory::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
