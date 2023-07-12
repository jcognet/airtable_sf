<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Directory;

class IsDirectoryDownloadable
{
    public function isDownloadable(Directory $directory): bool
    {
        return file_exists(ZipAllPictureDirectory::getFileName($directory->getPath()));
    }
}
