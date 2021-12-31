<?php
declare(strict_types=1);

namespace App\Service\Builder\Twitter;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Twitter\Message;

class MessageBuilder implements BuilderInterface
{
    public function build(array $data)
    {
        return new Message(
            $data['text'] ?? ''
        );
    }
}
