<?php

namespace PhpDDD\DomainDrivenDesign\Tests\User;

use PhpDDD\DomainDrivenDesign\User\Author;
use PhpDDD\DomainDrivenDesign\User\AuthorInterface;
use PhpDDD\DomainDrivenDesign\User\Robot;
use PHPUnit_Framework_TestCase;

/**
 * Test of the class Author.
 */
final class AuthorTest extends PHPUnit_Framework_TestCase
{
    public function testFromObject()
    {
        $mock   = $this->getMock(AuthorInterface::class);
        $author = Author::fromObject($mock);

        $this->assertNull($author->identifier);
        $this->assertEquals(get_class($mock), $author->type);
    }

    public function testRobot()
    {
        $author = Author::robot();
        $this->assertNull($author->identifier);
        $this->assertEquals(Robot::class, $author->type);
    }
}
