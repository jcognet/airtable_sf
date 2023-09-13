<?php
declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class LoginLinkHandler
{
    public function __construct(private readonly LoginLinkHandlerInterface $loginLinkHandler) {}

    public function createLink(UserInterface $user): string
    {
        $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user);

        return $loginLinkDetails->getUrl();
    }
}
