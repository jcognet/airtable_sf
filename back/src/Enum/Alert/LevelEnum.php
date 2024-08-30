<?php
declare(strict_types=1);

namespace App\Enum\Alert;

enum LevelEnum: int
{
    case LOW = 0;
    case MEDIUM = 50;
    case HIGH = 100;
    case GOOD_NEWS = 200;
}
