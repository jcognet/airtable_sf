<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\CriteriaBuilder;
use App\ValueObject\Random\Criteria;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RgesnRepository
{
    private const NB_TRY_RANDOM = 5;
    private array $records = [];
    private array $randomKey = [];

    public function __construct(
        private readonly HttpClientInterface $ecoresponsablegouvClient,
        private readonly CriteriaBuilder $criteriaBuilder
    ) {
    }

    public function fetchRandomData(): ?Criteria
    {
        if (count($this->records) === 0) {
            $this->records = json_decode(
                $this->ecoresponsablegouvClient->request(
                    'GET',
                    'publications/referentiel-general-ecoconception/export/referentiel-general-ecoconception-version-v1.json',
                )->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            )['criteres'];
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

        return $this->criteriaBuilder->build($this->records[$key]);
    }
}
