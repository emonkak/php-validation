<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\MaxLength;

/**
 * @covers Emonkak\Validation\Constraint\MaxLength
 */
class MaxLengthTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertNotEmpty((new MaxLength(2))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult)
    {
        $constraint = new MaxLength(2);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            ['', true],
            ['f', true],
            ['fo', true],
            ['foo', false]
        ];
    }
}
