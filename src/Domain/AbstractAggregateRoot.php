<?php

namespace PhpDDD\DomainDrivenDesign\Domain;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\Exception\BadMethodCallException;
use PhpDDD\Utils\ClassUtils;

abstract class AbstractAggregateRoot
{
    /**
     * List of non published events.
     *
     * @var AbstractEvent[]
     */
    private $events = [];

    /**
     * Get the unique identifier of this aggregate root.
     *
     * @return mixed
     */
    abstract public function getId();

    public function pullEvents()
    {
        $events       = $this->events;
        $this->events = [];

        return $events;
    }

    /**
     * @param AbstractEvent $event
     */
    protected function apply(AbstractEvent $event)
    {
        $event->aggregateRoot = $this;
        $this->executeEvent($event);
        $this->events[] = $event;
    }

    /**
     * @param AbstractEvent $event
     *
     * @throws BadMethodCallException
     */
    private function executeEvent(AbstractEvent $event)
    {
        $eventName = ClassUtils::getShortName($event);
        $method    = sprintf('apply%s', (string) $eventName);

        if (!method_exists($this, $method)) {
            throw new BadMethodCallException(
                sprintf(
                    'You must define the %s::%s(%s $event) method in order to apply event named "%s".',
                    get_class($this),
                    $method,
                    get_class($event),
                    $eventName
                )
            );
        }

        $this->$method($event);
    }
}
