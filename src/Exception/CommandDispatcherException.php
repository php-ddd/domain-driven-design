<?php

namespace PhpDDD\DomainDrivenDesign\Exception;

use PhpDDD\DomainDrivenDesign\Command\AbstractCommand;
use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;

/**
 *
 */
final class CommandDispatcherException extends \LogicException implements ExceptionInterface
{
    /**
     * @param AbstractCommand $command
     *
     * @return CommandDispatcherException
     */
    public static function commandHandlerNotFound(AbstractCommand $command)
    {
        return new self(sprintf('There is no known handler for the command type %s.', get_class($command)));
    }

    /**
     * @param AbstractCommand           $command
     * @param CommandHandlerInterface[] $commandHandlers
     *
     * @return CommandDispatcherException
     */
    public static function tooManyCommandHandler(AbstractCommand $command, array $commandHandlers)
    {
        $handlerClassNames = array_map(
            function (CommandHandlerInterface $commandHandler) {
                return get_class($commandHandler);
            },
            $commandHandlers
        );

        return new self(
            sprintf(
                'There are too many command handler for the command type %s. Candidates are %s.',
                get_class($command),
                implode(', ', $handlerClassNames)
            )
        );
    }

    /**
     * @param string                  $commandClassName
     * @param CommandHandlerInterface $previous
     * @param CommandHandlerInterface $current
     *
     * @return CommandDispatcherException
     */
    public static function commandHandlerAlreadyDefinedForCommand(
        $commandClassName,
        CommandHandlerInterface $previous,
        CommandHandlerInterface $current
    ) {
        $message = 'Trying to add handler %3$s handling command %1$s which is already handled by %2$s.';
        if (get_class($previous) === get_class($current)) {
            $message = 'Trying to add multiple handling method for the command %1$s in the handler %2$s';
        }

        return new self(sprintf($message, $commandClassName, get_class($previous), get_class($current)));
    }
}
