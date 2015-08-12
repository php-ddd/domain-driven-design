<?php

namespace PhpDDD\DomainDrivenDesign\Domain;

use PhpDDD\DomainDrivenDesign\Command\AbstractCommand;
use PhpDDD\DomainDrivenDesign\Command\CommandDispatcherInterface;
use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;
use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\Event\EventDispatcherInterface;
use PhpDDD\DomainDrivenDesign\Event\EventSubscriberInterface;

/**
 * The CommandEventDispatcher allows you to handle the flow from a Command to the events publication.
 */
final class CommandEventDispatcher implements CommandDispatcherInterface, EventDispatcherInterface
{
    /**
     * @var CommandDispatcherInterface
     */
    private $commandDispatcher;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param CommandDispatcherInterface $commandDispatcher
     * @param EventDispatcherInterface   $eventDispatcher
     */
    public function __construct(
        CommandDispatcherInterface $commandDispatcher,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->commandDispatcher = $commandDispatcher;
        $this->eventDispatcher   = $eventDispatcher;
    }

    /**
     * Try to handle the command given in argument.
     * It will look over every handlers registered and find the one that knows how handle it.
     *
     * @param AbstractCommand $command
     *
     * @return AbstractCommand
     */
    public function handle(AbstractCommand $command)
    {
        $this->commandDispatcher->handle($command);
        // Now that the command is handled, let's found if there is some events to publish
        $events = $this->extractEventsFromCommand($command);
        foreach ($events as $event) {
            // we will only publish event to synchronous listeners
            $this->publish($event);
        }

        return $command;
    }

    /**
     * Register a CommandHandler for one or more Command.
     *
     * @param CommandHandlerInterface $handler
     *
     * @return void
     */
    public function register(CommandHandlerInterface $handler)
    {
        $this->commandDispatcher->register($handler);
    }

    /**
     * @param AbstractEvent $event
     * @param bool          $asynchronous
     *
     * @return AbstractEvent
     */
    public function publish(AbstractEvent $event, $asynchronous = false)
    {
        return $this->eventDispatcher->publish($event, $asynchronous);
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function subscribe(EventSubscriberInterface $subscriber)
    {
        $this->eventDispatcher->subscribe($subscriber);
    }

    /**
     * @param AbstractCommand $command
     *
     * @return AbstractEvent[]
     */
    private function extractEventsFromCommand(AbstractCommand $command)
    {
        $events = [];
        foreach ($command->aggregateRoots as $aggregateRoot) {
            $events = array_merge($events, $aggregateRoot->pullEvents());
        }

        return $events;
    }
}
