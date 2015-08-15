<?php

namespace PhpDDD\DomainDrivenDesign\Tests\EventLog;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\EventLog\EventLog;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PHPUnit_Framework_TestCase;

/**
 * Test EventLog aggregate root.
 */
final class EventLogTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider addEventEntryProvider
     *
     * @param AbstractEvent $event
     */
    public function testAddEventEntry(AbstractEvent $event)
    {
        $eventLog = EventLog::addEventEntry($event);
        $this->assertInstanceOf(EventLog::class, $eventLog);
        $this->assertNull($eventLog->getId());
        if (null === $event->aggregateRoot) {
            $this->assertNull($eventLog->getAggregateRootId());
            $this->assertNull($eventLog->getAggregateRootType());
        } else {
            $this->assertEquals($event->aggregateRoot->getId(), $eventLog->getAggregateRootId());
            $this->assertEquals(get_class($event->aggregateRoot), $eventLog->getAggregateRootType());
        }
        $this->assertEquals($event->author, $eventLog->getAuthor());
        $this->assertEquals(get_class($event), $eventLog->getEventName());
        $this->assertEquals($event->date, $eventLog->getOccurredAt());
        $this->assertEquals(serialize($event), $eventLog->getMetadata());
    }

    /**
     * @return array
     */
    public function addEventEntryProvider()
    {
        return [
            [new TestEvent()],
            [new TestEvent(['myProperty' => 'test',])],
        ];
    }
}
