<?php
declare(strict_types=1);

namespace App\Service;

use App\Exception\Picture\ImageNotDownloadableException;
use Symfony\Component\Filesystem\Filesystem;

class FileDownloader
{
    public function download(
        string $url,
        string $destinationFile
    ): void {
        if (is_file($destinationFile)) {
            return;
        }

        $fs = new Filesystem();
        $fs->mkdir(dirname($destinationFile));

        file_put_contents(
            $destinationFile,
            fopen($url, 'r')
        );

        if (!is_file($destinationFile)) {
            throw new ImageNotDownloadableException($url);
        }
    }
}
