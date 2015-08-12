<?php

namespace PhpDDD\DomainDrivenDesign\Command;

/**
 * Manage the relation between a Command and its handler
 * A command must have one and only one handler.
 * An handler should handle one and only one command but it may handle more.
 * To handle more commands you have the choice between:
 * - handling an interface or
 * - handling a parent command class.
 */
interface CommandDispatcherInterface
{
    /**
     * Try to handle the command given in argument.
     * It will look over every handlers registered and find the one that knows how handle it.
     *
     * @param AbstractCommand $command
     *
     * @return AbstractCommand
     */
    public function handle(AbstractCommand $command);

    /**
     * Register a CommandHandler for one or more Command.
     *
     * @param CommandHandlerInterface $handler
     *
     * @return void
     */
    public function register(CommandHandlerInterface $handler);
}
