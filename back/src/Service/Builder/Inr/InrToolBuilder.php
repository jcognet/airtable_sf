<?php
declare(strict_types=1);

namespace App\Service\Builder\Inr;

use App\ValueObject\Inr\InrTool;
use Symfony\Component\DomCrawler\Crawler;

class InrToolBuilder
{
    public function build(string $data): ?InrTool
    {
        $crawler = new Crawler($data);
        $title = strip_tags($crawler->filter('h3')->html());

        try {
            $url = $crawler->filter('h3 a')->link()->getUri();
        } catch (\InvalidArgumentException) {
            return null;
        }

        $tags = $crawler->filter('.small2 a')->each(static fn ($node, $id) => ltrim((string) $node->text(), '#'));
        sort($tags);
        $text = $crawler->filter('p.small')->text();

        return new InrTool($title, $url, $tags, $text);
    }
}
