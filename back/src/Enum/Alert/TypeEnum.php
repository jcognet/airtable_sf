<?php
declare(strict_types=1);

namespace App\Enum\Alert;

enum TypeEnum: string
{
    case CUT = 'cut';
    case COLORING = 'coloring';
    case ABS = 'abs';
    case ABS_MAX_SERIES = 'abs_max_series';
    case ABS_CURRENT_SERIES = 'abs_current_series';
    case QI = 'qi';
    case MEAT_CURRENT_WITHOUT_SERIES = 'meat_current_without_series';
    case COFFEE_CURRENT_WITHOUT_SERIES = 'coffee_current_without_series';

    public function getLabel(): string
    {
        return match ($this) {
            self::ABS => 'abdo',
            self::ABS_CURRENT_SERIES => 'Séries abdo',
            self::ABS_MAX_SERIES => 'Max séries abdo',
            self::QI => 'qi',
            self::CUT => 'coupe',
            self::COLORING => 'teinte',
            self::MEAT_CURRENT_WITHOUT_SERIES => 'Série de jour sans viande',
            self::COFFEE_CURRENT_WITHOUT_SERIES => 'Série de jour sans café',
        };
    }
}
