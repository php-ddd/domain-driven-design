<?php

namespace PhpDDD\DomainDrivenDesign\Event;

interface EventDispatcherInterface
{
    /**
     * @param AbstractEvent $event
     * @param bool          $asynchronous
     *
     * @return AbstractEvent
     */
    public function publish(AbstractEvent $event, $asynchronous = false);

    /**
     * @param EventSubscriberInterface $subscriber
     *
     * @return void
     */
    public function subscribe(EventSubscriberInterface $subscriber);
}
