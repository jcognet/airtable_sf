<?php
declare(strict_types=1);

namespace App\Service\Archive;

use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;

class DataInputOuputHandler
{
    private string $path;

    public function __construct(string $deployArchiveJsonPath)
    {
        $this->path = $deployArchiveJsonPath;
    }

    public function write(string $data, Carbon $date): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->getFileName($date),
            json_encode([
                'data' => [
                    'content' => $data,
                ],
                'metadata' => [
                    'created' => $date,
                ],
            ])
        );
    }

    public function get(Carbon $date): ?array
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->getFileName($date))) {
            return null;
        }

        return json_decode(file_get_contents($this->getFileName($date)), true);
    }

    public function getHtml(Carbon $date): ?string
    {
        $content = $this->get($date);

        if ($content === null | !isset($content['data']['content'])) {
            return null;
        }

        return $content['data']['content'];
    }

    protected function getFileName(Carbon $date): string
    {
        return sprintf('%s/%s_newsletter.json', $this->path, $date->format('Y-m-d'));
    }
}
