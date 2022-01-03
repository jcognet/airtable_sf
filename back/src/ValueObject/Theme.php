<?php
declare(strict_types=1);

namespace App\ValueObject;

class Theme
{
    private string $mainColor;
    private string $secondaryColor;

    public function __construct(string $mainColor, string $secondaryColor)
    {
        $this->mainColor = $mainColor;
        $this->secondaryColor = $secondaryColor;
    }

    public function getMainColor(): string
    {
        return $this->mainColor;
    }

    public function getSecondaryColor(): string
    {
        return $this->secondaryColor;
    }
}
