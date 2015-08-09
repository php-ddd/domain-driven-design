<?php

namespace PhpDDD\DomainDrivenDesign\Tests\User;

use PhpDDD\DomainDrivenDesign\User\Robot;
use PHPUnit_Framework_TestCase;

/**
 * Test of the Robot class.
 */
final class RobotTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $robot = new Robot();

        $this->assertNull($robot->getId(), 'A robot should not have any identifier.');
    }
}
