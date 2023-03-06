<?php
declare(strict_types=1);

namespace App\Exception\Picture;

class ImageNotDownloadableException extends \RuntimeException
{
    public function __construct($urlImage)
    {
        parent::__construct(
            sprintf('Url not downloadable: %s.', $urlImage)
        );
    }
}
