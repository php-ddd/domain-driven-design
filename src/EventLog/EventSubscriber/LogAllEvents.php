<?php

namespace PhpDDD\DomainDrivenDesign\EventLog\EventSubscriber;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\Event\EventListener;
use PhpDDD\DomainDrivenDesign\Event\EventSubscriberInterface;
use PhpDDD\DomainDrivenDesign\EventLog\EventLog;
use PhpDDD\DomainDrivenDesign\EventLog\Repository\EventLogRepositoryInterface;

/**
 * Subscribe to every events and save them.
 */
final class LogAllEvents implements EventSubscriberInterface
{
    /**
     * @var EventLogRepositoryInterface
     */
    private $repository;

    /**
     * @return EventListener[] The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            new EventListener('logEvent'), // Subscribe to every event synchronously
        ];
    }

    /**
     * @param EventLogRepositoryInterface $repository
     */
    public function __construct(EventLogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AbstractEvent $event
     *
     * @return AbstractEvent
     */
    public function logEvent(AbstractEvent $event)
    {
        $eventLog = EventLog::addEventEntry($event);

        return $this->repository->save($eventLog);
    }
}
