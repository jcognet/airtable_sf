<?php
declare(strict_types=1);

namespace App\Service\Builder;

use App\Service\Repository\SujetList;
use App\ValueObject\Article;
use Carbon\Carbon;

class ArticleBuilder implements BuilderInterface
{
    private SujetList $sujetList;

    public function __construct(SujetList $sujetList)
    {
        $this->sujetList = $sujetList;
    }

    public function build(array $data): Article
    {
        $sujets = [];

        foreach ($data['fields']['Sujet'] as $sujetId) {
            $sujets[] = $this->sujetList->getById($sujetId);
        }

        return new Article(
            $data['fields']['Name'] ?? '',
            $data['fields']['body'] ?? $data['fields']['Citation'] ?? '',
            Carbon::parse($data['createdTime']),
            $sujets
        );
    }
}
