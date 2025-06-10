<?php
declare(strict_types=1);

namespace App\ValueObject\CiteDesBebes;

use Carbon\Carbon;
use Symfony\Component\Serializer\Annotation\Ignore;

class AvailibilitySales
{
    public function __construct(
        public readonly Carbon $day,
        public readonly Carbon $start,
        private ?Carbon $end = null,
        private bool $isSalesOpen = false,
        private bool $stateHasChanged = false
    ) {}

    #[Ignore]
    public function isSalesOpen(): bool
    {
        return $this->isSalesOpen;
    }

    public function setIsSalesOpen(bool $isSalesOpen): void
    {
        if ($isSalesOpen !== $this->isSalesOpen) {
            $this->end = Carbon::now();
            $this->stateHasChanged = true;
        }

        $this->isSalesOpen = $isSalesOpen;
    }

    public function getEnd(): ?Carbon
    {
        return $this->end;
    }

    #[Ignore]
    public function hasStateChanged(): bool
    {
        return $this->stateHasChanged;
    }
}
