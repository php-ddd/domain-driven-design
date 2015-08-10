<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Domain\Sample;

use PhpDDD\DomainDrivenDesign\Domain\AbstractAggregateRoot;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestOtherEvent;

final class TestAggregateRoot extends AbstractAggregateRoot
{
    /**
     * @var bool
     */
    private $editable;

    /**
     *
     */
    public function __construct()
    {
        $this->editable = true;
    }

    /**
     * This method is an entry point for your aggregate. It tries to alter your object.
     *
     * Inside, you should validate all the inputs, check that the aggregate current state allows this kind of behaviour
     * and if so, apply an Event.
     * If the aggregate current state does not allow such behaviour, you should probably throw an exception extending
     * the \DomainException. You will then be able to catch this kind of exception and display a nice message to the
     * user.
     */
    public function run()
    {
        if (false === $this->editable) {
            throw new \DomainException('You can not edit the TestAggregateRoot.');
        }
        // If we arrive here, we succeed. We can update the object
        // Rather than modify the Aggregate directly we apply an event.
        // Internally, this will call the applyTestEvent method
        $this->apply(new TestEvent());
    }

    /**
     * This method will throw a BadMethodCallException because there is no applyTestOtherEvent method defined.
     */
    public function testWithoutApplyMethod()
    {
        $this->apply(new TestOtherEvent());
    }

    /**
     * An event occurs. Since it's an event, there is nothing we can do to prevent the aggregate to be modified.
     * We should never add some test nor throw any exception inside this method.
     *
     * @param TestEvent $event
     *
     * @return TestEvent
     */
    protected function applyTestEvent(TestEvent $event)
    {
        $this->editable = false;

        return $event;
    }
}
