<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Command;

use PhpDDD\DomainDrivenDesign\Command\CommandDispatcher;
use PhpDDD\DomainDrivenDesign\Exception\CommandDispatcherException;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandHandlerDefiningSameCommandTwice;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandHandlerOne;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandHandlerTwo;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandOne;
use PhpDDD\DomainDrivenDesign\Tests\Command\Sample\TestCommandTwo;
use PHPUnit_Framework_TestCase;

/**
 * Test of the CommandDispatcher.
 */
final class CommandDispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommandDispatcher
     */
    private $commandDispatcher;
    /**
     * @var TestCommandHandlerOne
     */
    private $commandHandler;

    /**
     *
     */
    protected function setUp()
    {
        $this->commandHandler    = new TestCommandHandlerOne();
        $this->commandDispatcher = new CommandDispatcher();
        $this->commandDispatcher->register($this->commandHandler);
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->commandDispatcher = null;
    }

    /**
     *
     */
    public function testRegister()
    {
        $commandHandler    = new TestCommandHandlerOne();
        $commandDispatcher = new CommandDispatcher();

        $commandDispatcher->register($commandHandler);

        $this->assertCount(2, $commandDispatcher->getHandlers());
    }

    /**
     * @expectedException \PhpDDD\DomainDrivenDesign\Exception\CommandDispatcherException
     */
    public function testRegisterCommandMoreThanOnce()
    {
        $commandHandler    = new TestCommandHandlerOne();
        $commandDispatcher = new CommandDispatcher();

        $commandDispatcher->register($commandHandler);
        $commandDispatcher->register($commandHandler);
    }

    /**
     */
    public function testRegisterSameCommandByDifferentHandler()
    {
        $commandDispatcher = new CommandDispatcher();
        $commandDispatcher->register(new TestCommandHandlerOne());

        try {
            $commandDispatcher->register(new TestCommandHandlerTwo());
            $this->assertTrue(false, 'An exception of type CommandDispatcherException should have been thrown.');
        } catch (CommandDispatcherException $exception) {
            $this->assertTrue(true, 'The exception has been thrown.');
        }
    }

    public function testHandleWithCallable()
    {
        $this->commandDispatcher->handle(new TestCommandOne());

        $this->assertTrue(TestCommandHandlerOne::$firstCommandCalled);
        $this->assertFalse($this->commandHandler->secondCommandCalled);
    }

    public function testHandleWithMethodName()
    {
        $this->commandDispatcher->handle(new TestCommandTwo());

        $this->assertFalse(TestCommandHandlerOne::$firstCommandCalled);
        $this->assertTrue($this->commandHandler->secondCommandCalled);
    }

    /**
     * @expectedException \PhpDDD\DomainDrivenDesign\Exception\CommandDispatcherException
     */
    public function testHandleUnknownCommand()
    {
        $commandDispatcher = new CommandDispatcher();
        $commandDispatcher->handle(new TestCommandOne());
    }

    /**
     */
    public function testHandleSameCommandBySameHandler()
    {
        $commandDispatcher = new CommandDispatcher();
        $commandDispatcher->register(new TestCommandHandlerDefiningSameCommandTwice());

        try {
            $commandDispatcher->handle(new TestCommandOne());
            $this->assertTrue(false, 'An exception of type CommandDispatcherException should have been thrown.');
        } catch (CommandDispatcherException $exception) {
            $this->assertTrue(true, 'The exception has been thrown.');
        }
    }
}
