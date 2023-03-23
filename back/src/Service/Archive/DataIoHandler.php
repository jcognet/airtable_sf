<?php
declare(strict_types=1);

namespace App\Service\Archive;

use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;

class DataIoHandler
{
    public function __construct(
        private readonly string $deployArchiveJsonPath
    ) {
    }

    public function write(string $data, Carbon $date): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->getFileName($date),
            $data
        );
    }

    public function read(Carbon $date): ?array
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->getFileName($date))) {
            return null;
        }

        return json_decode(
            file_get_contents(
                $this->getFileName($date)
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    protected function getFileName(Carbon $date): string
    {
        return sprintf('%s/%s_newsletter.json', $this->deployArchiveJsonPath, $date->format('Y-m-d'));
    }
}
