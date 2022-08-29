<?php
declare(strict_types=1);

namespace App\Service\Git;

use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;

class TagHandler
{
    private string $path;

    public function __construct(string $deployJsonPath)
    {
        $this->path = $deployJsonPath;
    }

    public function write(string $tag): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->path,
            json_encode([
                'tag' => $tag,
                'date' => Carbon::now(),
            ])
        );
    }

    public function get(): array
    {
        return json_decode(file_get_contents($this->path), true);
    }
}
