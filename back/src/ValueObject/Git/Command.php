<?php
declare(strict_types=1);

namespace App\ValueObject\Git;

class Command
{
    private array $process;
    private string $return;

    public function __construct(array $process, string $return)
    {
        $this->process = $process;
        $this->return = $return;
    }

    public function getProcess(): array
    {
        return $this->process;
    }

    public function getReturn(): string
    {
        return $this->return;
    }
}
