<?php
declare(strict_types=1);

namespace App\Extension;

use App\Service\Converter\ConvertBlockTypeToManagerType;
use App\Service\Security\LoginLinkHandler;
use App\ValueObject\NewsletterBlockManager\BlockType;
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
        private readonly ConvertBlockTypeToManagerType $convertBlockTypeToManagerType
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_google_mail', $this->isGoogleMail(...)),
            new TwigFunction('email_connection', $this->getEmailConnection(...)),
            new TwigFunction('convert_to_manager_type', $this->convertToManagerType(...)),
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

    public function convertToManagerType($managerClass): BlockType
    {
        return $this->convertBlockTypeToManagerType->reverseConvert(
            $managerClass
        );
    }
}
