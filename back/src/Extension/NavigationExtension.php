<?php
declare(strict_types=1);

namespace App\Extension;

use App\Service\Converter\ConvertBlockTypeToManagerType;
use App\Service\Page\ArticleSeeAgainListFetcher;
use App\Service\Page\BotDouxFetcher;
use App\Service\Page\InterestingTopicListFetcher;
use App\Service\Page\MainImageFetcher;
use App\Service\Page\MeteoListFetcher;
use App\Service\Page\QuestionFetcher;
use App\Service\Picture\RandomPictorySelector;
use App\Service\Security\LoginLinkHandler;
use App\ValueObject\Article\ArticleSeeAgainList;
use App\ValueObject\Article\Image;
use App\ValueObject\Article\InterestingTopicList;
use App\ValueObject\Meteo\MeteoList;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;
use App\ValueObject\Newspaper;
use App\ValueObject\Picture\Picture;
use App\ValueObject\Qcm\Question;
use App\ValueObject\Twitter\Message;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavigationExtension extends AbstractExtension
{
    private const USER_LOGIN = 'jcognet';

    public function __construct(
        private readonly UserProviderInterface $userProvider,
        private readonly LoginLinkHandler $loginLinkHandler,
        private readonly string $absoluteUrlFront,
        private readonly ConvertBlockTypeToManagerType $convertBlockTypeToManagerType,
        private readonly MainImageFetcher $mainImageFetcher,
        private readonly BotDouxFetcher $botDouxFetcher,
        private readonly RandomPictorySelector $randomPictorySelector,
        private readonly InterestingTopicListFetcher $interestingTopicListFetcher,
        private readonly ArticleSeeAgainListFetcher $articleSeeAgainListFetcher,
        private readonly MeteoListFetcher $meteoListFetcher,
        private readonly QuestionFetcher $questionFetcher
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_google_mail', $this->isGoogleMail(...)),
            new TwigFunction('email_connection', $this->getEmailConnection(...)),
            new TwigFunction('convert_to_manager_type', $this->convertToManagerType(...)),
            new TwigFunction('main_image', $this->mainImage(...)),
            new TwigFunction('bot_doux', $this->botDoux(...)),
            new TwigFunction('random_image_from_directory', $this->randomImageFromDirectory(...)),
            new TwigFunction('interesting_topic_list', $this->interestingTopicList(...)),
            new TwigFunction('article_see_again', $this->articleSeeAgain(...)),
            new TwigFunction('meteo_list', $this->meteoList(...)),
            new TwigFunction('question', $this->question(...)),
        ];
    }

    public function isGoogleMail(): bool
    {
        return \PHP_SAPI === 'cli';
    }

    public function getEmailConnection(): string
    {
        try {
            return
                $this->loginLinkHandler->createLink(
                    $this->userProvider->loadUserByIdentifier(self::USER_LOGIN)
                );
        } catch (UserNotFoundException) {
            return $this->absoluteUrlFront;
        }
    }

    public function convertToManagerType(ManagerType $managerType): BlockType
    {
        return $this->convertBlockTypeToManagerType->reverseConvert(
            $managerType
        );
    }

    public function mainImage(Newspaper $newspaper): ?Image
    {
        return $this->mainImageFetcher->fetch($newspaper);
    }

    public function botDoux(Newspaper $newspaper): ?Message
    {
        return $this->botDouxFetcher->fetch($newspaper);
    }

    public function randomImageFromDirectory(string $directory): Picture
    {
        return $this->randomPictorySelector->select($directory);
    }

    public function interestingTopicList(Newspaper $newspaper): ?InterestingTopicList
    {
        return $this->interestingTopicListFetcher->fetch($newspaper);
    }

    public function articleSeeAgain(Newspaper $newspaper): ?ArticleSeeAgainList
    {
        return $this->articleSeeAgainListFetcher->fetch($newspaper);
    }

    public function meteoList(Newspaper $newspaper): ?MeteoList
    {
        return $this->meteoListFetcher->fetch($newspaper);
    }

    public function question(Newspaper $newspaper): ?Question
    {
        return $this->questionFetcher->fetch($newspaper);
    }
}
