<?php
declare(strict_types=1);

namespace App\Service\Block\Google;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\ImageUrl;
use App\ValueObject\Random\ListImageUrl;

class CurrenciesManager implements BlockManagerInterface
{
    private const URL = [
        'JPY' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRZ0glaaNB5WUbCzXpNim5sz3XGttZtuQJi0HtqBzy6YqdajFUG4llJ5qqwZshCFXS70FCjEyISTI2R/pubchart?oid=511775458&format=image',
        'NOK' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRZ0glaaNB5WUbCzXpNim5sz3XGttZtuQJi0HtqBzy6YqdajFUG4llJ5qqwZshCFXS70FCjEyISTI2R/pubchart?oid=999898887&format=image',
        'CAD' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRZ0glaaNB5WUbCzXpNim5sz3XGttZtuQJi0HtqBzy6YqdajFUG4llJ5qqwZshCFXS70FCjEyISTI2R/pubchart?oid=1901740061&format=image',
        'USD' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRZ0glaaNB5WUbCzXpNim5sz3XGttZtuQJi0HtqBzy6YqdajFUG4llJ5qqwZshCFXS70FCjEyISTI2R/pubchart?oid=1606872023&format=image',
        'GBP' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRZ0glaaNB5WUbCzXpNim5sz3XGttZtuQJi0HtqBzy6YqdajFUG4llJ5qqwZshCFXS70FCjEyISTI2R/pubchart?oid=1322521676&format=image',
    ];

    public function getContent(): ?BlockInterface
    {
        $currencies = [];

        foreach (self::URL as $currency => $url) {
            $currencies[] = new ImageUrl(
                sprintf('Evolution de %s', $currency),
                $url
            );
        }

        return new ListImageUrl(
            'Monnaies',
            $currencies,
        );
    }
}
