<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Inr\InrToolBuilder;
use App\ValueObject\Inr\InrTool;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InrRepository
{
    private const NB_TRY_RANDOM = 5;

    private array $records = [];
    private array $randomKey = [];

    public function __construct(
        private readonly HttpClientInterface $inrClient,
        private readonly InrToolBuilder $inrToolBuilder
    ) {}

    public function fetchRandomData(): ?InrTool
    {
        if (count($this->records) === 0) {
            $html =
                $this->inrClient->request(
                    'GET',
                    'search.php?search=&go_random=J%27ai+de+la+chance',
                )->getContent();

            $crawler = new Crawler($html);
            $this->records = $crawler->filter('.card3')->getIterator()->getArrayCopy();
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

        return $this->inrToolBuilder->build($this->records[$key]->ownerDocument->saveHTML($this->records[$key]));
    }
}
