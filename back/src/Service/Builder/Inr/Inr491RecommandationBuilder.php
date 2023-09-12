<?php
declare(strict_types=1);

namespace App\Service\Builder\Inr;

use App\ValueObject\Inr\Inr491Recommandation;
use Symfony\Component\DomCrawler\Crawler;

class Inr491RecommandationBuilder
{
    public function __construct(
        private readonly Inr491ItemBuilder $itemBuilder
    ) {}

    public function build(string $data): ?Inr491Recommandation
    {
        $crawler = new Crawler($data);
        $recommandation = new Inr491Recommandation(
            trim(
                mb_substr(
                    strip_tags(
                        $crawler->filter('button')->html()
                    ),
                    0,
                    -1
                )
            )
        );

        foreach ($crawler->filter('.card3')->getIterator()->getArrayCopy() as $itemData) {
            $recommandation->addItem(
                $this->itemBuilder->build($itemData->ownerDocument->saveHTML($itemData))
            );
        }

        return $recommandation;
    }
}
