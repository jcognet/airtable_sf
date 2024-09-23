<?php
declare(strict_types=1);

namespace App\ValueObject\LifeEvent;

class ListEvent
{
    private readonly array $events;

    /**
     * @param Event[] $events
     */
    public function __construct(
        array $events
    ) {
        usort($events, static fn (Event $a, Event $b) => $a->getDate() <=> $b->getDate());
        $this->events = $events;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
