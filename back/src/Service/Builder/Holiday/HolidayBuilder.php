<?php
declare(strict_types=1);

namespace App\Service\Builder\Holiday;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Holiday\Holiday;
use Carbon\Carbon;

class HolidayBuilder implements BuilderInterface
{
    public function build(array $data): Holiday
    {
        return new Holiday(
            id: $data['id'],
            name: $data['fields']['Nom'],
            startDate: Carbon::parse($data['fields']['Date de début']),
            endDate: Carbon::parse($data['fields']['Date de fin']),
            place: $data['fields']['Lieu'],
            placeMeteo: $data['fields']['Lieu météo'] ?? null,
            picDirectory: $data['fields']['Répertoire photo'] ?? null,
            comment: $data['fields']['Commentaire'] ?? null,
        );
    }
}
