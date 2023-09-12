<?php
declare(strict_types=1);

namespace App\Extension;

use App\Service\ColorBulmaFetcher;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BulmaExtension extends AbstractExtension
{
    public function __construct(private readonly ColorBulmaFetcher $bulmaFetcher) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_random_color_bulma', $this->randomColor(...)),
        ];
    }

    public function randomColor(): string
    {
        return $this->bulmaFetcher->getRandomColor();
    }
}
