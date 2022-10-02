<?php
declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavigationExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_google_mail', $this->isGoogleMail(...)),
        ];
    }

    public function isGoogleMail(): bool
    {
        return \PHP_SAPI === 'cli';
    }
}
