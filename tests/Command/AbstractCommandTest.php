<?php

namespace PhpDDD\DomainDrivenDesign\Tests\Command;

use PhpDDD\DomainDrivenDesign\Command\AbstractCommand;
use PhpDDD\DomainDrivenDesign\Domain\AbstractAggregateRoot;
use PhpDDD\DomainDrivenDesign\User\Author;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 *
 */
final class AbstractCommandTest extends PHPUnit_Framework_TestCase
{
    const TESTED_CLASS = AbstractCommand::class;

    public function testEmptyConstructor()
    {
        $mock = $this->getMockForAbstractCommand([]);
        $this->assertEquals(Author::robot(), $mock->requester);
    }

    public function testConstructorWithAuthor()
    {
        $requester  = Author::robot();
        $parameters = ['requester' => $requester];

        $mock = $this->getMockForAbstractCommand($parameters);
        $this->assertEquals($requester, $mock->requester);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithUnknownProperty()
    {
        $this->getMockForAbstractCommand(['unknownProperty' => 'value']);
    }

    /**
     *
     */
    public function testAddAggregateRoot()
    {
        $mock = $this->getMockForAbstractCommand([]);
        $this->assertEquals([], $mock->aggregateRoots);
        $mock->addAggregateRoot($this->getMockForAggregateRoot());

        $this->assertCount(1, $mock->aggregateRoots);
    }

    /**
     * @param array $constructorArgs
     *
     * @return PHPUnit_Framework_MockObject_MockObject|AbstractCommand
     */
    private function getMockForAbstractCommand(array $constructorArgs)
    {
        return $this->getMockBuilder(self::TESTED_CLASS)
            ->setConstructorArgs([$constructorArgs])
            ->getMockForAbstractClass();
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|AbstractAggregateRoot
     */
    private function getMockForAggregateRoot()
    {
        return $this->getMockForAbstractClass(AbstractAggregateRoot::class);
    }
}
