<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Directory;
use App\ValueObject\Picture\DownloableInformation;

class DownloadableInformationFactory
{
    public function get(Directory $directory): DownloableInformation
    {
        $fileName = ZipAllPictureDirectory::getFileName($directory->getPath());
        $isDownloadable = file_exists($fileName);
        $nbFiles = count($directory->getPictures());
        $size = null;

        if ($isDownloadable) {
            $size = filesize($fileName);
        }

        return new DownloableInformation(
            nbFiles: $nbFiles,
            size: $size,
            isDownloadable: $isDownloadable
        );
    }
}
