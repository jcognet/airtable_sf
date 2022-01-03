<?php
declare(strict_types=1);

namespace App\Service\Git;

use Carbon\Carbon;

class TagReader
{
    private string $deployJsonPath;
    private ?array $data = null;

    public function __construct(string $deployJsonPath)
    {
        $this->deployJsonPath = $deployJsonPath;
    }

    public function read(): array
    {
        if ($this->data === null) {
            $this->data = json_decode(file_get_contents($this->deployJsonPath), true);
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
