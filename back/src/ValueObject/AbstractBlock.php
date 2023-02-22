<?php
declare(strict_types=1);

namespace App\ValueObject;

use App\ValueObject\NewsletterBlockManager\ManagerType;

abstract class AbstractBlock implements BlockInterface
{
    private ?ManagerType $managerType = null;

    public function setManagerType(string $managerType): void
    {
        $this->managerType = new ManagerType($managerType);
    }

    public function getManagerType(): ?ManagerType
    {
        return $this->managerType;
    }
}
