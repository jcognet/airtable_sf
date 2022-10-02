<?php
declare(strict_types=1);

namespace App\Service\Git;

use Carbon\Carbon;

class TagReader
{
    private ?array $data = null;

    public function __construct(private readonly string $deployJsonPath)
    {
    }

    public function read(): array
    {
        if ($this->data === null) {
            $this->data = json_decode(file_get_contents($this->deployJsonPath), true, 512, JSON_THROW_ON_ERROR);
        }

        return $this->data;
    }

    public function getLastTag(): string
    {
        $this->read();

        return $this->data['tag'];
    }

    public function getLastDeploy(): Carbon
    {
        $this->read();

        return Carbon::parse($this->data['date']);
    }
}
