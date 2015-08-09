<?php

namespace PhpDDD\DomainDrivenDesignTests\Event;

use PhpDDD\DomainDrivenDesign\Event\AbstractEvent;
use PhpDDD\DomainDrivenDesign\User\Author;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 *
 */
final class AbstractEventTest extends PHPUnit_Framework_TestCase
{
    const TESTED_CLASS = AbstractEvent::class;

    public function testEmptyConstructor()
    {
        $mock = $this->getMockForAbstractEvent([]);
        $this->assertNull($mock->author);
    }

    public function testConstructorWithAuthor()
    {
        $author     = Author::robot();
        $parameters = ['author' => $author];

        $mock = $this->getMockForAbstractEvent($parameters);
        $this->assertEquals($author, $mock->author);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithUnknownProperty()
    {
        $this->getMockForAbstractEvent(['unknownProperty' => 'value']);
    }

    /**
     * @param $constructorArgs
     *
     * @return PHPUnit_Framework_MockObject_MockObject|AbstractEvent
     */
    private function getMockForAbstractEvent($constructorArgs)
    {
        return $this->getMockBuilder(self::TESTED_CLASS)
            ->setConstructorArgs([$constructorArgs])
            ->getMockForAbstractClass();
    }
}
