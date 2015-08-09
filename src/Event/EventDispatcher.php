<?php

namespace PhpDDD\DomainDrivenDesign\Event;

use PhpDDD\Utils\ClassUtils;

final class EventDispatcher
{
    /**
     * @var EventListener[]
     */
    private $listeners = [];

    /**
     * @param AbstractEvent $event
     * @param bool          $asynchronous
     *
     * @return AbstractEvent
     */
    public function publish(AbstractEvent $event, $asynchronous = false)
    {
        $eventName = ClassUtils::getCanonicalName($event);

        $this->doPublish($this->getListeners($event, $asynchronous), $eventName, $event);

        return $event;
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $subscribedEvent) {
            $subscribedEvent->setSubscriber($subscriber);
            $this->listeners[] = $subscribedEvent;
        }
    }

    /**
     * @param AbstractEvent $event
     * @param bool          $asynchronous
     *
     * @return EventListener[]
     */
    public function getListeners(AbstractEvent $event, $asynchronous = false)
    {
        return array_filter(
            $this->listeners,
            function (EventListener $eventSubscriber) use ($asynchronous, $event) {
                $supportedEvent = $eventSubscriber->getEventClassName();

                if ($eventSubscriber->isAsynchronous() !== $asynchronous) {
                    return false;
                }
                if (null === $supportedEvent) {
                    return true;
                }

                return $event instanceof $supportedEvent;
            }
        );
    }

    /**
     * Triggers the listeners of an event.
     *
     * This method can be overridden to add functionality that is executed
     * for each listener.
     *
     * @param EventListener[] $listeners The event listeners.
     * @param string          $eventName The name of the event to dispatch.
     * @param AbstractEvent   $event     The event object to pass to the event handlers/listeners.
     */
    private function doPublish(array $listeners, $eventName, AbstractEvent $event)
    {
        foreach ($listeners as $listener) {
            call_user_func($listener->getMethod(), $event, $eventName, $this);
        }
    }
}
