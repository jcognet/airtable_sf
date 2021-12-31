<?php
declare(strict_types=1);

namespace App\ValueObject\Twitter;

class User
{
    private string $name;
    private string $profileImageUrl;
    private string $username;

    public function __construct(string $name, string $profileImageUrl, string $username)
    {
        $this->name = $name;
        $this->profileImageUrl = $profileImageUrl;
        $this->username = $username;
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
