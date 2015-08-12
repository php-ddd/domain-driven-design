<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Command\Sample;

use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;
use PhpDDD\DomainDrivenDesign\Tests\Domain\Sample\TestAggregateRoot;

/**
 *
 */
final class TestCommandHandlerOne implements CommandHandlerInterface
{
    /**
     * @var bool
     */
    public static $firstCommandCalled = false;
    /**
     * @var bool
     */
    public $secondCommandCalled = false;

    /**
     * Returns an array of command class name this handler wants to handle.
     *
     * The array keys are the command class names (a parent class name or an interface if you wish).
     * The value can be the method name or any callable to call when the command is dispatched.
     *
     * For instance:
     *
     *  [
     *      MyCommand::class => 'myMethod',
     *      MyCommandInterface::class => [self::class, 'myStaticMethod'],
     *  ]
     *
     * @return callable[]|string[]
     */
    public static function getHandlingMethods()
    {
        return [
            TestCommandOne::class => [self::class, 'testFirstCommand'],
            TestCommandTwo::class => 'testSecondCommand',
        ];
    }

    /**
     *
     */
    public function __construct()
    {
        self::$firstCommandCalled = false;
    }

    /**
     * @param TestCommandOne $command
     *
     * @return TestCommandOne
     */
    public static function testFirstCommand(TestCommandOne $command)
    {
        self::$firstCommandCalled = true;
        $aggregate                = new TestAggregateRoot();
        $aggregate->run();

        $command->addAggregateRoot($aggregate);

        return $command;
    }

    /**
     *
     */
    public function testSecondCommand()
    {
        $this->secondCommandCalled = true;
    }
}
