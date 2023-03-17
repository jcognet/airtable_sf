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

    public function getManagerTypeValue(): ?string
    {
        if ($this->managerType === null) {
            return null;
        }

        return $this->managerType->getType();
    }

    // Used for deserializsation process
    public function getClass(): string
    {
        return $this::class; // $this to get the real class not the current one (AbstractBlock)
    }
}
