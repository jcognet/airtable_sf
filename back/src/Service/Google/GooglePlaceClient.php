<?php
declare(strict_types=1);

namespace App\Service\Google;

use App\Exception\Google\GoogleErrorException;
use App\Service\Builder\Google\PlaceBuilder;
use App\ValueObject\Google\Place;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GooglePlaceClient
{
    private const MY_POS = '48.86604 2.405603';
    private const SUCCESS_KEYWORD = 'OK';
    private const SLEEP_DURATION = 5;
    private const MAX_GOOGLE_CALLS = 3;

    private ?string $nextPageToken = null;

    public function __construct(
        private readonly HttpClientInterface $googlePlaceApiClient,
        private readonly PlaceBuilder $placeBuilder,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @return Place[]
     */
    public function import(string $research): array
    {
        $param = [
            'keyword' => $research,
            'location' => self::MY_POS,
            'rankby' => 'distance',
        ];

        $places = $this->query($param);
        $nbCalls = 1; // We already made one call

        while ($this->nextPageToken && $nbCalls < self::MAX_GOOGLE_CALLS) {
            $this->logger->debug(
                sprintf(
                    'Sleep a little (%ds). Call: %d.',
                    self::SLEEP_DURATION,
                    $nbCalls
                )
            );
            sleep(self::SLEEP_DURATION);
            $places = [
                ...$places,
                ...$this->query(
                    [
                        'pagetoken' => $this->nextPageToken,
                    ]
                ),
            ];
            $this->logger->debug(sprintf('Found %d places.', count($places)));
            ++$nbCalls;
        }

        $this->nextPageToken = null; // We clean the buffer

        return $places;
    }

    private function query(array $param): array
    {
        $places = [];

        $response = json_decode(
            $this->googlePlaceApiClient->request(
                'GET',
                'nearbysearch/json',
                [
                    'query' => $param,
                ]
            )->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if ($response['status'] !== self::SUCCESS_KEYWORD) {
            throw new GoogleErrorException($response['status']);
        }

        foreach ($response['results'] as $result) {
            $places[] = $this->placeBuilder->build($result);
        }

        $this->logger->debug(sprintf('Found %d places.', count($places)));

        if (isset($response['next_page_token'])) {
            $this->nextPageToken = $response['next_page_token'];
        }

        return $places;
    }
}
