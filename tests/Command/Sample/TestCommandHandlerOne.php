<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Command\Sample;

use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;

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
     *
     */
    public static function testFirstCommand()
    {
        self::$firstCommandCalled = true;
    }

    /**
     *
     */
    public function testSecondCommand()
    {
        $this->secondCommandCalled = true;
    }
}
