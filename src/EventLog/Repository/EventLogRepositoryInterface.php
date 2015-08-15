<?php

namespace PhpDDD\DomainDrivenDesign\EventLog\Repository;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\EventLog\EventLog;

/**
 * The way you want to use the EventLog system is entirely your choice.
 * When dealing with Domain objects, you may always want to use interface for things that can change.
 * Dealing with a database, a file system, a cache system or whatever you want is **implementation details**.
 *
 * It's not the job of the Domain to store data.
 * Its job is to maintain a consistency.
 */
interface EventLogRepositoryInterface
{
    /**
     * This interface allow you to choose the implementation you want to save EventLog entries.
     * For instance:
     *  - if you want to save it using doctrine ORM, you will probably do a persist and flush
     *  - if you want to save it using the file system, you can serialize the event and add it in an events.log file.
     *
     * @param EventLog $eventLog
     *
     * @return AbstractEvent The event saved. Can be useful if you hydrate the event (set an id)
     */
    public function save(EventLog $eventLog);
}
