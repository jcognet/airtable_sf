<?php
declare(strict_types=1);

namespace App\Service\Archive;

use App\ValueObject\Archive\NewsLetter;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;

class DataInputOuputHandler
{
    private string $path;

    public function __construct(string $deployArchiveJsonPath)
    {
        $this->path = $deployArchiveJsonPath;
    }

    public function write(
        NewsLetter $newsLetter
    ): void {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->getFileName($newsLetter->getDate()),
            json_encode([
                'data' => [
                    'content' => $newsLetter->getContent(),
                ],
                'metadata' => [
                    'created' => $newsLetter->getDate(),
                    'was_sent' => $newsLetter->wasSent(),
                ],
            ])
        );
    }

    public function get(Carbon $date): ?NewsLetter
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->getFileName($date))) {
            return null;
        }

        $data = json_decode(file_get_contents($this->getFileName($date)), true);

        return new NewsLetter(
            Carbon::parse($data['metadata']['created']),
            $data['data']['content'],
            isset($data['metadata']['was_sent']) ? (bool) $data['metadata']['was_sent'] : false
        );
    }

    protected function getFileName(Carbon $date): string
    {
        return sprintf('%s/%s_newsletter.json', $this->path, $date->format('Y-m-d'));
    }
}
