<?php
declare(strict_types=1);

namespace App\Service\Block\Twitter;

use App\Service\Block\BlockManagerInterface;
use App\Service\Twitter\TwitterClient;
use App\ValueObject\BlockInterface;

class BotDouxManager implements BlockManagerInterface
{
    private const TWITTER_ACCOUNT = 'JeSuisTonBot';

    private TwitterClient $twitterClient;

    public function __construct(TwitterClient $twitterClient)
    {
        $this->twitterClient = $twitterClient;
    }

    public function getContent(): ?BlockInterface
    {
        $message = $this->twitterClient->fetchRandomMessageFromUser(self::TWITTER_ACCOUNT);
        $message->setTitle('Petit mot doux du jour');

        return $message;
    }
}
