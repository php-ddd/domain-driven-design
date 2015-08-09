<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Event;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\Event\EventDispatcher;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEventSubscriber;
use PHPUnit_Framework_TestCase;

/**
 * Test for the class EventDispatcher.
 */
final class EventDispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;
    /**
     * @var AbstractEvent
     */
    private $event;

    /**
     *
     */
    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $this->event      = new TestEvent();
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->dispatcher = null;
        $this->event      = null;
    }

    public function testInitialState()
    {
        $this->assertEquals([], $this->dispatcher->getListeners($this->event));
        $this->assertEquals([], $this->dispatcher->getListeners($this->event, true));
    }

    public function testAddSubscriber()
    {
        $this->dispatcher->addSubscriber(new TestEventSubscriber());
        $this->assertCount(2, $this->dispatcher->getListeners($this->event));
        $this->assertCount(2, $this->dispatcher->getListeners($this->event, true));
    }

    public function testPublish()
    {
        $subscriber = new TestEventSubscriber();
        $this->dispatcher->addSubscriber($subscriber);

        $this->dispatcher->publish($this->event);
        $this->assertEquals(2, $subscriber->nbPreFooCalled);
    }

    public function testAsynchronousPublish()
    {
        $subscriber = new TestEventSubscriber();
        $this->dispatcher->addSubscriber($subscriber);

        $this->dispatcher->publish($this->event, true);
        $this->assertEquals(1, $subscriber->nbPreFooCalled);
    }
}
