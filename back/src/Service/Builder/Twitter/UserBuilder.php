<?php
declare(strict_types=1);

namespace App\Service\Builder\Twitter;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Twitter\User;

class UserBuilder implements BuilderInterface
{
    public function build(array $data)
    {
        return new User(
            $data['name'],
            $data['profile_image_url'],
            $data['username']
        );
    }
}
