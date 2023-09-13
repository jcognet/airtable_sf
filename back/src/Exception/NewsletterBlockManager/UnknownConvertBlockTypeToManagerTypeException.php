<?php
declare(strict_types=1);

namespace App\Exception\NewsletterBlockManager;

use App\ValueObject\NewsletterBlockManager\BlockType;

class UnknownConvertBlockTypeToManagerTypeException extends \RuntimeException
{
    public function __construct(BlockType $type, array $list)
    {
        parent::__construct(
            sprintf(
                'Unknown block type for conversion: %s. Allowed are: %s',
                $type->value,
                implode(
                    ', ',
                    array_map(
                        static fn ($format) => $format->value,
                        $list
                    )
                )
            )
        );
    }
}
