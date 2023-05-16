<?php
declare(strict_types=1);

namespace App\ValueObject\Holiday;

use Carbon\Carbon;

class Holiday
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly Carbon $startDate,
        private readonly Carbon $endDate,
        private readonly string $place,
        private readonly ?string $placeMeteo,
        private readonly ?string $picDirectory,
        private readonly ?string $comment
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function getPlaceMeteo(): ?string
    {
        return $this->placeMeteo;
    }

    public function getPicDirectory(): ?string
    {
        return $this->picDirectory;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
