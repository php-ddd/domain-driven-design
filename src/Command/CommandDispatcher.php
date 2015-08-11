<?php

namespace PhpDDD\DomainDrivenDesign\Command;

use PhpDDD\DomainDrivenDesign\Exception\CommandDispatcherException;

/**
 * Implementation of the CommandDispatcherInterface.
 */
final class CommandDispatcher implements CommandDispatcherInterface
{
    /**
     * List of command handler subscribed per command.
     * This is mainly used for debug (exceptions).
     *
     * @var CommandHandlerInterface[]
     */
    private $handlers = [];
    /**
     * List of methods to call when a command is triggered.
     *
     * @var callable[]
     */
    private $handlingMethods = [];

    /**
     * Get the handler link to the command (if any) and run the callable associated.
     * This method will try to look for handlers registered to:
     * - the command class name
     * - a parent of the current command
     * - an interface that the current command may implement.
     *
     * @param AbstractCommand $command
     *
     * @return AbstractCommand
     */
    public function handle(AbstractCommand $command)
    {
        $handlingMethods = $this->getHandlingMethodForCommand($command);
        $nbMethods       = count($handlingMethods);
        if (0 === $nbMethods) {
            throw CommandDispatcherException::commandHandlerNotFound($command);
        } elseif (1 !== $nbMethods) {
            throw CommandDispatcherException::tooManyCommandHandler($command, $this->getHandlerForCommand($command));
        }
        $method = current($handlingMethods);

        call_user_func($method, $command);

        return $command;
    }

    /**
     * @param CommandHandlerInterface $handler
     */
    public function register(CommandHandlerInterface $handler)
    {
        foreach ($handler->getHandlingMethods() as $commandClassName => $callable) {
            if (isset($this->handlers[$commandClassName])) {
                throw CommandDispatcherException::commandHandlerAlreadyDefinedForCommand(
                    $commandClassName,
                    $this->handlers[$commandClassName],
                    $handler
                );
            }

            // if callable is a string, then it should be a method name of the command handler
            if (!is_callable($callable)) {
                $callable = [$handler, $callable];
            }

            $this->handlingMethods[$commandClassName] = $callable;
            $this->handlers[$commandClassName]        = $handler;
        }
    }

    /**
     * @return CommandHandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @param AbstractCommand $command
     *
     * @return callable[]
     */
    private function getHandlingMethodForCommand(AbstractCommand $command)
    {
        return $this->filterForCommand($this->handlingMethods, $command);
    }

    /**
     * @param AbstractCommand $command
     *
     * @return CommandHandlerInterface[]
     */
    private function getHandlerForCommand(AbstractCommand $command)
    {
        return $this->filterForCommand($this->handlers, $command);
    }

    /**
     * @param array           $property
     * @param AbstractCommand $command
     *
     * @return array
     */
    private function filterForCommand(array $property, AbstractCommand $command)
    {
        $filtered = [];
        foreach ($property as $commandClassName => $handler) {
            if ($command instanceof $commandClassName) {
                // After that, we still need to check if there is no other handler defined for this command.
                // This is because we allow command handler to listen to parent class or interface.
                $filtered[] = $handler;
            }
        }

        return $filtered;
    }
}
