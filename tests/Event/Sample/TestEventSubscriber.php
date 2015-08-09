<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Event\Sample;

use PhpDDD\DomainDrivenDesign\Event\EventListener;
use PhpDDD\DomainDrivenDesign\Event\EventSubscriberInterface;

final class TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var int
     */
    public $nbPreFooCalled = 0;
    /**
     * @var int
     */
    public static $nbStaticCall = 0;

    /**
     * @return EventListener[] The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            new EventListener('preFoo'),
            new EventListener('preFoo', TestEvent::class),
            new EventListener('preFoo', TestEvent::class, true),
            new EventListener([self::class, 'staticCall'], TestEvent::class, true),
        ];
    }

    public static function staticCall()
    {
        ++static::$nbStaticCall;
    }

    public function preFoo()
    {
        ++$this->nbPreFooCalled;
    }
}
