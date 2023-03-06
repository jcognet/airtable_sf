<?php
declare(strict_types=1);

namespace App\ValueObject\Picture;

class CachedImage
{
    public function __construct(
        private readonly string $class,
        private readonly string $recordId,
        private readonly string $field,
        private readonly string $recordTitle,
        private readonly string $slug,
        private readonly Picture $picture
    ) {
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getRecordId(): string
    {
        return $this->recordId;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getRecordTitle(): string
    {
        return $this->recordTitle;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getPicture(): Picture
    {
        return $this->picture;
    }
}
