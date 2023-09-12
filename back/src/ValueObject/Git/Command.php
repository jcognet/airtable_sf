<?php
declare(strict_types=1);

namespace App\ValueObject\Git;

class Command
{
    public function __construct(private readonly array $process, private readonly string $return) {}

    public function getProcess(): array
    {
        return $this->process;
    }

    public function getReturn(): string
    {
        return $this->return;
    }
}
