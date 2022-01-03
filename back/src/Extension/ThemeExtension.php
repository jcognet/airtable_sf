<?php
declare(strict_types=1);

namespace App\Extension;

use App\Service\ThemeFetcher;
use App\ValueObject\Theme;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ThemeExtension extends AbstractExtension
{
    private ThemeFetcher $themeFetcher;

    public function __construct(ThemeFetcher $themeFetcher)
    {
        $this->themeFetcher = $themeFetcher;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_random_theme', [$this, 'randomColor']),
        ];
    }

    public function randomColor(): Theme
    {
        return $this->themeFetcher->getRandomTheme();
    }
}
