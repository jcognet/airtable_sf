<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\Exception\Builder\LastUsedUpdaterNotImplementedException;
use App\ValueObject\LastUsedTrait;
use Carbon\Carbon;

class LastUsedManager
{
    private const LAST_USED_AIRTABLE_FIELD_NAME = 'Date d\'utilisation';

    public function onPostBuild(mixed $object, array $data): void
    {
        if (!$this->supports($object::class)) {
            return;
        }

        if (!isset($data['fields'][self::LAST_USED_AIRTABLE_FIELD_NAME])) {
            return;
        }

        $object->setLastUsed(
            Carbon::parse($data['fields'][self::LAST_USED_AIRTABLE_FIELD_NAME])
        );
        $object->setAirtableId($data['id']);
    }

    public function onPostDenormalize(string $class, array $data): mixed
    {
        if (!$this->supports($class)) {
            throw new LastUsedUpdaterNotImplementedException($class);
        }

        $lastUsed = (isset($data['lastUsed'])) ? Carbon::parse($data['lastUsed']) : null;
        $airtableId = $data['airtableId'];

        unset($data['lastUsed'],  $data['airtableId']);
        $object = new $class(...$data);
        $object->setLastUsed($lastUsed);
        $object->setAirtableId($airtableId);

        return $object;
    }

    public function unBuild(mixed $object): array
    {
        if (!$this->supports($object::class)) {
            throw new LastUsedUpdaterNotImplementedException($object::class);
        }

        return [
            'id' => $object->getAirTableId(),
            'fields' => [
                'Date d\'utilisation' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
    }

    public function supports(string $class): bool
    {
        $reflection = new \ReflectionClass($class);
        $usedTraits = $reflection->getTraitNames();

        return in_array(LastUsedTrait::class, $usedTraits, true);
    }
}
