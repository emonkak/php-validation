<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\Between;

/**
 * @covers Emonkak\Validation\Constraint\Between
 */
class BetweenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorThrowsInvalidArgumentException()
    {
        new Between(3, 1);
    }

    public function testGetDeclaration()
    {
        $this->assertNotEmpty((new Between(1, 3))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult)
    {
        $constraint = new Between(1, 3);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            [0, false],
            [1, true],
            [2, true],
            [3, true],
            [4, false]
        ];
    }
}
