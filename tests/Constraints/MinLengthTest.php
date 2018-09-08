<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\MinLength;

/**
 * @covers Emonkak\Validation\Constraint\MinLength
 */
class MinLengthTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertNotEmpty((new MinLength(3))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult)
    {
        $constraint = new MinLength(3);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            ['', false],
            ['f', false],
            ['fo', false],
            ['foo', true]
        ];
    }
}
