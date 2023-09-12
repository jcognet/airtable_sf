<?php
declare(strict_types=1);

namespace App\Service\Builder\Picture;

use App\Service\FileDownloader;
use App\Service\Picture\CachedImageDirectoryGetter;
use App\Service\Picture\PictureFactory;
use App\ValueObject\Picture\CachedImage;
use Symfony\Component\String\Slugger\SluggerInterface;

class CachedImageBuilder
{
    public function __construct(
        private readonly PictureFactory $pictureFactory,
        private readonly SluggerInterface $slugger,
        private readonly CachedImageDirectoryGetter $directoryGetter,
        private readonly FileDownloader $fileDownloader
    ) {}

    public function build(
        string $class,
        string $recordId,
        string $field,
        ?string $recordTitle,
        ?string $airtableUrl
    ): ?CachedImage {
        if ($recordTitle === null || $airtableUrl === null) {
            return null;
        }

        $slug = sprintf(
            '%s_%s.jpg',
            $this->slugger->slug(
                strtolower($recordTitle)
            ),
            $recordId
        );

        $localPathPicture = sprintf(
            '%s/%s',
            $this->directoryGetter->get(
                $class,
                $field
            ),
            $slug
        );

        $this->fileDownloader->download(
            $airtableUrl,
            $localPathPicture
        );

        return new CachedImage(
            class: $class,
            recordId: $recordId,
            field: $field,
            recordTitle: $recordTitle,
            slug: $slug,
            picture: $this->pictureFactory->get($localPathPicture)
        );
    }
}
