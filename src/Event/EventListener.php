<?php

namespace PhpDDD\DomainDrivenDesign\Event;

use PhpDDD\DomainDrivenDesign\Exception\InvalidArgumentException;

final class EventListener
{
    /**
     * @var bool
     */
    private $asynchronous;
    /**
     * @var string
     */
    private $eventClassName;

    /**
     * @var callable|string
     */
    private $method;

    /**
     * @param callable|string $method
     * @param string|null     $eventClassName
     * @param bool            $asynchronous
     */
    public function __construct($method, $eventClassName = null, $asynchronous = false)
    {
        static::validateMethod($method);
        static::validateEventClassName($eventClassName);
        static::validateAsynchronous($asynchronous);
        $this->eventClassName = $eventClassName;
        $this->method         = $method;
        $this->asynchronous   = (bool) $asynchronous;
    }

    /**
     * @param bool $asynchronous
     */
    public static function validateAsynchronous($asynchronous)
    {
        if (!is_bool($asynchronous)) {
            throw InvalidArgumentException::wrongType('asynchronous', $asynchronous, 'boolean');
        }
    }

    /**
     * @param string|null $eventClassName
     */
    public static function validateEventClassName($eventClassName)
    {
        if (null !== $eventClassName && !is_string($eventClassName)) {
            throw InvalidArgumentException::wrongType('eventClassName', $eventClassName, 'null or string');
        }
    }

    /**
     * @param string|callable $method
     */
    public static function validateMethod($method)
    {
        if (!is_string($method) && !is_callable($method)) {
            throw InvalidArgumentException::wrongType('method', $method, 'callable or string');
        }
    }

    /**
     * @return bool
     */
    public function isAsynchronous()
    {
        return $this->asynchronous;
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function setSubscriber(EventSubscriberInterface $subscriber)
    {
        if (!is_callable($this->method)) {
            $this->method = [$subscriber, $this->method];
        }
    }

    /**
     * @return string
     */
    public function getEventClassName()
    {
        return $this->eventClassName;
    }

    /**
     * @return callable|string
     */
    public function getMethod()
    {
        return $this->method;
    }
}
