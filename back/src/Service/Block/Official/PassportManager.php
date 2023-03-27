<?php
declare(strict_types=1);

namespace App\Service\Block\Official;

use App\Service\Block\BlockManagerInterface;
use App\Service\Repository\Official\PassportRepository;
use App\ValueObject\BlockInterface;
use App\ValueObject\Official\Passport;

class PassportManager implements BlockManagerInterface
{
    public function __construct(
        private readonly PassportRepository $passportRepository
    ) {
    }

    public function getContent(): ?BlockInterface
    {
        return new Passport($this->passportRepository->getUrl());
    }
}
