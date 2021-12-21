<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\Builder\BuilderInterface;
use App\Service\Repository\Article\SujetRepository;
use App\ValueObject\Article\Image;

class ImageBuilder implements BuilderInterface
{
    private SujetRepository $sujetRepository;

    public function __construct(SujetRepository $sujetRepository)
    {
        $this->sujetRepository = $sujetRepository;
    }

    public function build(array $data): Image
    {
        $sujets = [];

        if (isset($data['fields']['Sujet'])) {
            foreach ($data['fields']['Sujet'] as $sujetId) {
                $sujets[] = $this->sujetRepository->getById($sujetId);
            }
        }

        return new Image(
            $data['fields']['Name'] ?? '',
            $data['fields']['Image'][0]['url'] ?? null,
            $sujets,
            $data['fields']['Source'] ?? '',
        );
    }
}
