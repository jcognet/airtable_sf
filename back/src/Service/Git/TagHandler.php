<?php
declare(strict_types=1);

namespace App\Service\Git;

use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;

class TagHandler
{
    public function __construct(private readonly string $deployJsonPath) {}

    public function write(string $tag): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->deployJsonPath,
            json_encode([
                'tag' => $tag,
                'date' => Carbon::now(),
            ], JSON_THROW_ON_ERROR)
        );
    }

    public function get(): array
    {
        return json_decode(file_get_contents($this->deployJsonPath), true, 512, JSON_THROW_ON_ERROR);
    }
}
