<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Domain;

use PhpDDD\DomainDrivenDesign\Command\CommandDispatcher;
use PhpDDD\DomainDrivenDesign\Command\CommandDispatcherInterface;
use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;
use PhpDDD\DomainDrivenDesign\Domain\CommandEventDispatcher;
use PhpDDD\DomainDrivenDesign\Event\EventDispatcherInterface;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandHandlerOne;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandOne;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEventSubscriber;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 *
 */
final class CommandEventDispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject|CommandDispatcherInterface
     */
    private $commandDispatcher;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var CommandEventDispatcher
     */
    private $commandEventDispatcher;

    protected function setUp()
    {
        $this->commandDispatcher      = $this->getMockForCommandDispatcher();
        $this->eventDispatcher        = $this->getMockForEventDispatcher();
        $this->commandEventDispatcher = new CommandEventDispatcher($this->commandDispatcher, $this->eventDispatcher);
    }

    protected function tearDown()
    {
        $this->commandDispatcher      = null;
        $this->eventDispatcher        = null;
        $this->commandEventDispatcher = null;
    }

    public function testHandle()
    {
        $commandDispatcher      = new CommandDispatcher();
        $eventDispatcher        = $this->getMockForEventDispatcher();
        $commandEventDispatcher = new CommandEventDispatcher($commandDispatcher, $eventDispatcher);
        $commandEventDispatcher->register(new TestCommandHandlerOne());
        $commandEventDispatcher->subscribe(new TestEventSubscriber());

        // the TestEvent is added to the aggregate
        $event = new TestEvent();
        $eventDispatcher
            ->expects($this->once())
            ->method('publish')
            ->willReturn($event);

        $command = new TestCommandOne();
        $result  = $commandEventDispatcher->handle($command);
        $this->assertEquals($command, $result);
    }

    public function testRegister()
    {
        $this->commandDispatcher->expects($this->once())
            ->method('register')
            ->willReturn(null);

        $this->commandEventDispatcher->register(new TestCommandHandlerOne());
    }

    public function testSubscribe()
    {
        $this->eventDispatcher->expects($this->once())
            ->method('subscribe')
            ->willReturn(null);

        $this->commandEventDispatcher->subscribe(new TestEventSubscriber());
    }

    public function testPublish()
    {
        $this->commandEventDispatcher->subscribe(new TestEventSubscriber());
        $event = new TestEvent();
        $this->eventDispatcher->expects($this->once())
            ->method('publish')
            ->willReturn($event);

        $return = $this->commandEventDispatcher->publish($event);

        $this->assertEquals($event, $return);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|CommandHandlerInterface
     */
    private function getMockForCommandDispatcher()
    {
        return $this
            ->getMockBuilder(CommandDispatcherInterface::class)
            ->setMethods(['register', 'handle'])
            ->getMockForAbstractClass();
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    private function getMockForEventDispatcher()
    {
        return $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->setMethods(['subscribe', 'publish'])
            ->getMockForAbstractClass();
    }
}
