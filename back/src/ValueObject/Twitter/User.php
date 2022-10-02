<?php
declare(strict_types=1);

namespace App\ValueObject\Twitter;

class User
{
    public function __construct(private readonly string $name, private readonly string $profileImageUrl, private readonly string $username)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProfileImageUrl(): string
    {
        return $this->profileImageUrl;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
