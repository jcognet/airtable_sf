<?php
declare(strict_types=1);

namespace App\Service;

class ColorBulmaFetcher
{
    private const LIST_COLORS = [
        'white',
        'light',
        'dark',
        'primary',
        'link',
        'info',
        'success',
        'warning',
        'danger',
    ];

    public function getRandomColor(): string
    {
        return self::LIST_COLORS[array_rand(self::LIST_COLORS)];
    }
}
