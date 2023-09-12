<?php
declare(strict_types=1);

namespace App\Service\Builder\Inr;

use App\ValueObject\Inr\Inr491Item;
use Symfony\Component\DomCrawler\Crawler;

class Inr491ItemBuilder
{
    public function __construct(
        private readonly string $inr491BaseUrl
    ) {}

    public function build(string $data): ?Inr491Item
    {
        $title = null;
        $crawler = new Crawler(
            node: $data,
            baseHref: $this->inr491BaseUrl
        );

        if ($crawler->filter('p.type-recommandation')->count() > 0) {
            $title = $crawler->filter('.type-recommandation')->html();
        }

        if ($crawler->filter('p.type-conseil')->count() > 0) {
            $title = $crawler->filter('.type-conseil')->html();
        }

        return new Inr491Item(
            strip_tags($title),
            $crawler->filter('.card3')->link()->getUri()
        );
    }
}
