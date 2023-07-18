<?php
declare(strict_types=1);

namespace App\ValueObject;

use Carbon\Carbon;

trait LastUsedTrait
{
    private ?Carbon $lastUsed = null;
    private ?string $airtableId = null;

    public function getLastUsed(): ?Carbon
    {
        return $this->lastUsed;
    }

    public function setLastUsed(Carbon $date): void
    {
        $this->lastUsed = $date;
    }

    public function getAirtableId(): ?string
    {
        return $this->airtableId;
    }

    public function setAirtableId(?string $airtableId): void
    {
        $this->airtableId = $airtableId;
    }
}
