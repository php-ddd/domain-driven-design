<?php

namespace PhpDDD\DomainDrivenDesign\Tests\EventLog\EventSubscriber;

use PhpDDD\DomainDrivenDesign\Event\EventListener;
use PhpDDD\DomainDrivenDesign\EventLog\EventSubscriber\LogAllEvents;
use PhpDDD\DomainDrivenDesign\EventLog\Repository\EventLogRepositoryInterface;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PHPUnit_Framework_TestCase;

/**
 * Test of the LogAllEvents class
 */
final class LogAllEventsTest extends PHPUnit_Framework_TestCase
{

    public function testGetSubscribedEvents()
    {
        $eventListeners = LogAllEvents::getSubscribedEvents();
        $this->assertCount(1, $eventListeners, 'LogAllEvents should only use one callable method.');
        /**
         * @var EventListener $eventListener
         */
        $eventListener = array_shift($eventListeners);
        $this->assertInstanceOf(EventListener::class, $eventListener);
        $this->assertFalse($eventListener->isAsynchronous());
        $this->assertNull($eventListener->getEventClassName());
    }

    public function testLogEvent()
    {
        $repositoryStub = $this->getMockBuilder(EventLogRepositoryInterface::class)
            ->setMethods(['save'])
            ->getMockForAbstractClass();

        $repositoryStub->expects($this->once())
            ->method('save')
            ->willReturnArgument(0);

        $logAllEvents = new LogAllEvents($repositoryStub);
        $logAllEvents->logEvent(new TestEvent());
    }
}
