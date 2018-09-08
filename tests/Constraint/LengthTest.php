<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\Length;

/**
 * @covers Emonkak\Validation\Constraint\Length
 */
class LengthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorThrowsInvalidArgumentException()
    {
        new Length(3, 1);
    }

    public function testGetDeclaration()
    {
        $this->assertNotEmpty((new Length(1, 3))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult)
    {
        $constraint = new Length(1, 3);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            ['', false],
            ['f', true],
            ['fo', true],
            ['foo', true],
            ['fooo', false]
        ];
    }
}
