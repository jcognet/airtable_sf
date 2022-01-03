<?php
declare(strict_types=1);

namespace App\Service;

use App\ValueObject\Theme;

class ThemeFetcher
{
    private const PURPLE = '7354c4';
    private const DARK_RED = 'c45461';
    private const GREEN = '658a5c';
    private const BLUE = '5f8ed9';
    private const BLACK = '000000';
    private const YELLOW = 'ed3b18';

    private const PURPLE_SECONDARY = 'e6ddfb';
    private const DARK_RED_SECONDARY = 'fad9d9';
    private const GREEN_SECONDARY = '98d989';
    private const BLUE_SECONDARY = 'bdd6ff';
    private const BLACK_SECONDARY = 'cccccc';
    private const YELLOW_SECONDARY = 'a9d938';

    public function getRandomTheme(): Theme
    {
        $themes = self::getThemes();

        return $themes[array_rand($themes)];
    }

    /**
     * @return Theme[]
     */
    private static function getThemes(): array
    {
        return [
            new Theme(self::PURPLE, self::PURPLE_SECONDARY),
            new Theme(self::DARK_RED, self::DARK_RED_SECONDARY),
            new Theme(self::GREEN, self::GREEN_SECONDARY),
            new Theme(self::BLUE, self::BLUE_SECONDARY),
            new Theme(self::BLACK, self::BLACK_SECONDARY),
            new Theme(self::YELLOW, self::YELLOW_SECONDARY),
        ];
    }
}
