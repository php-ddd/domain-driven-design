<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Command\Sample;

use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;

final class TestCommandHandlerDefiningSameCommandTwice implements CommandHandlerInterface
{
    /**
     * This should fails when we call the EventDispatcher::handle method with a TestCommandOne command.
     * This is due to the fact that TestCommandOne implements TestCommandInterface.
     * Hence, the eventDispatcher does not know which of the two closure to run.
     *
     * @return callable[]|string[]
     */
    public static function getHandlingMethods()
    {
        return [
            TestCommandOne::class       => function (TestCommandOne $command) { },
            TestCommandInterface::class => function (TestCommandInterface $command) { },
        ];
    }
}
