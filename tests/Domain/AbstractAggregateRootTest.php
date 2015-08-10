<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Domain;

use PhpDDD\DomainDrivenDesign\Tests\Domain\Sample\TestAggregateRoot;
use PhpDDD\DomainDrivenDesign\Tests\Event\Sample\TestEvent;
use PHPUnit_Framework_TestCase;

/**
 *
 */
final class AbstractAggregateRootTest extends PHPUnit_Framework_TestCase
{
    public function testPullEvents()
    {
        $aggregate = new TestAggregateRoot();

        $events = $aggregate->pullEvents();
        $this->assertCount(0, $events, 'Should not contain any event initially.');

        $aggregate->run();

        $events = $aggregate->pullEvents();
        $this->assertCount(1, $events);
        $this->assertEquals([new TestEvent()], $events);
        $this->assertEmpty($aggregate->pullEvents());
    }

    /**
     * @expectedException \PhpDDD\DomainDrivenDesign\Exception\BadMethodCallException
     */
    public function testApplyWrongEvent()
    {
        $aggregate = new TestAggregateRoot();
        $aggregate->testWithoutApplyMethod();
    }
}
