<?php

namespace PhpDDD\DomainDrivenDesign\Event;

interface EventSubscriberInterface
{
    /**
     * @return EventListener[] The event names to listen to
     */
    public static function getSubscribedEvents();
}
