<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\Builder\BuilderInterface;
use App\Service\Repository\Article\SujetRepository;
use App\ValueObject\Article\Article;
use App\ValueObject\Article\Status;
use Carbon\Carbon;

class ArticleBuilder implements BuilderInterface
{
    private SujetRepository $sujetRepository;

    public function __construct(SujetRepository $sujetRepository)
    {
        $this->sujetRepository = $sujetRepository;
    }

    public function build(array $data): Article
    {
        $sujets = [];

        if (isset($data['fields']['Sujet'])) {
            foreach ($data['fields']['Sujet'] as $sujetId) {
                $sujets[] = $this->sujetRepository->getById($sujetId);
            }
        }

        $status = null;
        if (isset($data['fields']['Status'])) {
            $status = new Status($data['fields']['Status']);
        }

        return new Article(
            $data['fields']['Name'] ?? '',
            $data['fields']['body'] ?? $data['fields']['Citation'] ?? '',
            Carbon::parse($data['createdTime']),
            $sujets,
            $status
        );
    }
}
