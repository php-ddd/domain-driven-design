<?php

namespace PhpDDD\DomainDrivenDesign\Command;

/**
 * To preserve the Single Responsibility principle (SRP), a command handler should manage only one command.
 * Since this is a framework, we add more flexibility and allow you to handle more than one command at a time.
 */
interface CommandHandlerInterface
{
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
    public static function getHandlingMethods();
}
