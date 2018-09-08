<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\LessThan;

/**
 * @covers Emonkak\Validation\Constraint\LessThan
 */
class LessThanTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertContains('123', (new LessThan(123))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($criterion, $value, $expectedResult)
    {
        $constraint = new LessThan($criterion);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            [10, 0, true],
            [10, 1, true],
            [10, 9, true],
            [10, 10, false],
            [10, 11, false],
            [10, 20, false],
        ];
    }
}
