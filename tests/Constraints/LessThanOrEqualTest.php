<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\LessThanOrEqual;

/**
 * @covers Emonkak\Validation\Constraint\LessThanOrEqual
 */
class LessThanOrEqualTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertContains('123', (new LessThanOrEqual(123))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($criterion, $value, $expectedResult)
    {
        $constraint = new LessThanOrEqual($criterion);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            [10, 0, true],
            [10, 1, true],
            [10, 9, true],
            [10, 10, true],
            [10, 11, false],
            [10, 20, false],
        ];
    }
}
