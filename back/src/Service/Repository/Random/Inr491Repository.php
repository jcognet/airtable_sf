<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Inr\Inr491FamilleBuilder;
use App\Service\Builder\Inr\Inr491RecommandationBuilder;
use App\ValueObject\Inr\Famille;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Inr491Repository
{
    private const NB_TRY_RANDOM = 5;
    private const LIST_FAMILLE = [
        'strategie',
        'contenus',
        'specifications',
        'uxui',
        'architecture',
        'frontend',
        'backend',
        'hebergement',
    ];

    private array $records = [];
    private ?Famille $famille = null;
    private array $randomKey = [];

    public function __construct(
        private readonly HttpClientInterface $inr491Client,
        private readonly Inr491FamilleBuilder $familleBuilder,
        private readonly Inr491RecommandationBuilder $recommandationBuilder,
    ) {}

    public function fetchRandomData(): ?Famille
    {
        if (count($this->records) === 0) {
            try {
                $request = $this->inr491Client->request(
                    'GET',
                    sprintf('?famille=%s', $this->getRandomUrlFamille()),
                );
                $html = $request->getContent();
            } catch (TransportException) {
                return null;
            }

            $crawler = new Crawler($html);
            $this->famille = $this->familleBuilder->build(
                $crawler->filter('h1')->html(),
                $crawler->filter('.description-famille')->html(),
                $request->getInfo('url')
            );
            $this->records = $crawler->filter('.recommandation')->getIterator()->getArrayCopy();
        }

        if (count($this->records) === 0) {
            return null;
        }

        $count = 0;
        $key = array_rand($this->records);
        while ($count < self::NB_TRY_RANDOM && in_array($key, $this->randomKey, true)) {
            $key = array_rand($this->records);
            ++$count;
        }

        if (in_array($key, $this->randomKey, true)) {
            return null;
        }

        $this->randomKey[] = $key;

        $this->famille->setRandomContent(
            $this->recommandationBuilder->build(
                $this->records[$key]->ownerDocument->saveHTML($this->records[$key])
            )
        );

        return $this->famille;
    }

    private function getRandomUrlFamille(): string
    {
        $key = array_rand(self::LIST_FAMILLE);

        return self::LIST_FAMILLE[$key];
    }
}
