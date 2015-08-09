<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Event;

use PhpDDD\DomainDrivenDesign\Event\EventListener;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEventSubscriber;
use PHPUnit_Framework_TestCase;

/**
 * Test for the class EventListener.
 */
final class EventListenerTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $eventListener = new EventListener('myMethod', TestEvent::class);
        $this->assertEquals('myMethod', $eventListener->getMethod());
        $this->assertEquals(TestEvent::class, $eventListener->getEventClassName());
        $this->assertFalse($eventListener->isAsynchronous());
    }

    /**
     * @dataProvider wrongConstructorProvider
     * @expectedException \PhpDDD\DomainDrivenDesign\Exception\InvalidArgumentException
     *
     * @param mixed $param1
     * @param mixed $param2
     * @param mixed $param3
     */
    public function testConstructorWithWrongArguments($param1, $param2, $param3)
    {
        new EventListener($param1, $param2, $param3);
    }

    public function testSetSubscriber()
    {
        $eventListener = new EventListener('preFoo', TestEvent::class);

        $this->assertTrue(is_string($eventListener->getMethod()));
        $eventListener->setSubscriber(new TestEventSubscriber());
        $this->assertTrue(is_callable($eventListener->getMethod()));
    }

    /**
     * @return array
     */
    public function wrongConstructorProvider()
    {
        return [
            [5, 'all', true],
            ['callable', 5, true],
            ['callable', 'all', 'true'],
        ];
    }
}
