<?php
declare(strict_types=1);

namespace App\Exception\NewsletterBlockManager;

use App\ValueObject\NewsletterBlockManager\BlockType;

class UnknownBlockTypeException extends \RuntimeException
{
    public function __construct(string $type)
    {
        parent::__construct(
            sprintf(
                'Unknown block type: %s. Allowed are: %s',
                $type,
                implode(
                    ', ',
                    array_map(
                        fn ($format) => $format->value,
                        BlockType::cases()
                    )
                )
            )
        );
    }
}
