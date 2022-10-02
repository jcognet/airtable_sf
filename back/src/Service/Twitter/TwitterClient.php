<?php
declare(strict_types=1);

namespace App\Service\Twitter;

use App\Service\Builder\Twitter\MessageBuilder;
use App\Service\Builder\Twitter\UserBuilder;
use App\ValueObject\Twitter\Message;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TwitterClient
{
    public function __construct(private readonly HttpClientInterface $twitterClient, private readonly MessageBuilder $messageBuilder, private readonly UserBuilder $userBuilder)
    {
    }

    public function fetchRandomMessageFromUser(string $account): ?Message
    {
        $messages = json_decode($this->twitterClient->request('GET', sprintf('tweets/search/recent/?query=from:%s', $account))->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $dataMessages = $messages['data'];
        $randomMessage = $this->messageBuilder->build($dataMessages[array_rand($dataMessages)]);

        if ($randomMessage === null) {
            return null;
        }

        $user = json_decode($this->twitterClient->request('GET', sprintf('users/by/username/%s?user.fields=profile_image_url', $account))->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $user = $this->userBuilder->build($user['data']);

        $randomMessage->setUser($user);

        return $randomMessage;
    }
}
