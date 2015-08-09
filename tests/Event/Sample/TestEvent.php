<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Event\Sample;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;

/**
 * This is a basic event. It contains three properties:
 * - myProperty
 * - author (inherited from the AbstractEvent class)
 * - date (inherited from the AbstractEvent class)
 *
 * An event should be POPO (plain old PHP object)
 *
 * Note that:
 * - every properties are public. This is a design choice.
 * - there is no constructor. See the parent constructor
 */
final class TestEvent extends AbstractEvent
{
    public $myProperty;
}
