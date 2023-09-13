<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\GoodPracticeBuilder;
use App\ValueObject\Random\GoodPractice;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoodPracticeOrganizationRepository
{
    private const NB_TRY_RANDOM = 5;
    private array $records = [];
    private array $randomKey = [];

    public function __construct(
        private readonly HttpClientInterface $ecoresponsablegouvClient,
        private readonly GoodPracticeBuilder $goodPracticeBuilder
    ) {}

    public function fetchRandomData(): ?GoodPractice
    {
        if (count($this->records) === 0) {
            $themes = json_decode(
                $this->ecoresponsablegouvClient->request(
                    'GET',
                    'publications/bonnes-pratiques/guide-bonnes-pratiques-numerique-responsable-export-version-v1.json',
                )->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            )['thematiques'];

            foreach ($themes as $theme) {
                foreach ($theme['bonnesPratiques'] as $rawGoodPractice) {
                    $this->records[] = $this->goodPracticeBuilder->build($rawGoodPractice);
                }
            }
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

        return $this->records[$key];
    }
}
