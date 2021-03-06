<?php
declare(strict_types=1);

namespace App\ValueObject\Twitter;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class Message implements BlockInterface
{
    private string $content;
    private ?User $user;
    private string $title = '';

    public function __construct(string $content, ?User $user = null, ?string $title = null)
    {
        $this->content = $content;
        $this->user = $user;
        if (null !== $title) {
            $this->title = $title;
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getType(): BlockType
    {
        return new BlockType(BlockType::BOT_DOUX_BLOCK);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
