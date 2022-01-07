<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\CriteriaBuilder;
use App\ValueObject\Random\Criteria;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RgsenRepository
{
    private const NB_TRY_RANDOM = 5;

    private HttpClientInterface $rgsenClient;
    private array $records = [];
    private array $randomKey = [];
    private CriteriaBuilder $criteriaBuilder;

    public function __construct(
        HttpClientInterface $rgsenClient,
        CriteriaBuilder $criteriaBuilder
    ) {
        $this->rgsenClient = $rgsenClient;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    public function fetchRandomData(): ?Criteria
    {
        if (count($this->records) === 0) {
            $this->records = json_decode(
                $this->rgsenClient->request(
                    'GET',
                    'referentiel-general-ecoconception-version-beta.json',
                )->getContent(),
                true
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
