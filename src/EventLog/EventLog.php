<?php

namespace PhpDDD\DomainDrivenDesign\EventLog;

use DateTime;
use PhpDDD\DomainDrivenDesign\Domain\AbstractAggregateRoot;
use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\User\Author;

/**
 *
 */
final class EventLog extends AbstractAggregateRoot
{
    /**
     * @var mixed This will depend on how you save the object
     */
    private $id;

    /**
     * @var mixed Identifier of the aggregate root
     */
    private $aggregateRootId;

    /**
     * Type of aggregate root. It should be a unique string that identify an aggregate root type.
     * For instance, you may use the Fully-Qualified Class Name.
     * Combined with the aggregate root id, you can point to a specific domain object.
     *
     * @var string
     */
    private $aggregateRootType;

    /**
     * The event name.
     *
     * @var string
     */
    private $eventName;

    /**
     * Events have some properties that vary depending on the event class.
     * These properties need to be stored.
     *
     * @var string The event serialized
     */
    private $metadata;

    /**
     * Who request the action.
     *
     * @var Author
     */
    private $author;

    /**
     * @var DateTime
     */
    private $occurredAt;

    /**
     * @param mixed    $aggregateRootId
     * @param string   $aggregateRootType
     * @param Author   $author
     * @param string   $eventName
     * @param DateTime $occurredAt
     * @param string   $metadata
     */
    private function __construct(
        $aggregateRootId,
        $aggregateRootType,
        Author $author,
        $eventName,
        DateTime $occurredAt,
        $metadata
    ) {
        // Here we should create an Event like this: $this->apply(new LogEntryAdded(...);
        // But doing so will probably create an infinite loop when you want to subscribe to all events
        // Instead, we make an exception so you don't need to subscribe to every events except this one
        $this->aggregateRootId   = $aggregateRootId;
        $this->aggregateRootType = $aggregateRootType;
        $this->author            = $author;
        $this->eventName         = $eventName;
        $this->occurredAt        = $occurredAt;
        $this->metadata          = $metadata;
    }

    /**
     * @param AbstractEvent $event
     *
     * @return EventLog
     */
    public static function addEventEntry(AbstractEvent $event)
    {
        return new self(
            null !== $event->aggregateRoot ? $event->aggregateRoot->getId() : null,
            null !== $event->aggregateRoot ? get_class($event->aggregateRoot) : null,
            $event->author,
            get_class($event),
            $event->date,
            serialize($event)
        );
    }

    /**
     * Get the unique identifier of this aggregate root.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAggregateRootId()
    {
        return $this->aggregateRootId;
    }

    /**
     * @return string
     */
    public function getAggregateRootType()
    {
        return $this->aggregateRootType;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return DateTime
     */
    public function getOccurredAt()
    {
        return $this->occurredAt;
    }
}
