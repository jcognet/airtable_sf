<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\Builder\BuilderInterface;
use App\Service\Builder\Picture\CachedImageBuilder;
use App\Service\Repository\Article\SujetRepository;
use App\ValueObject\Article\Image;

class ImageBuilder implements BuilderInterface
{
    public function __construct(
        private readonly SujetRepository $sujetRepository,
        private readonly CachedImageBuilder $cachedImageBuilder
    ) {
    }

    public function build(array $data): Image
    {
        $sujets = [];

        if (isset($data['fields']['Sujet'])) {
            foreach ($data['fields']['Sujet'] as $sujetId) {
                $sujets[] = $this->sujetRepository->getById($sujetId);
            }
        }

        $cachedImage = $this->cachedImageBuilder->build(
            Image::class,
            $data['id'],
            'url',
            $data['fields']['Name'] ?? null,
            $data['fields']['Image'][0]['url'] ?? null,
        );

        return new Image(
            $data['fields']['Name'] ?? '',
            $cachedImage,
            $sujets,
            $data['fields']['Source'] ?? '',
        );
    }
}
