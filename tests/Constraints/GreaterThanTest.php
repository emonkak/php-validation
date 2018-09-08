<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\GreaterThan;

/**
 * @covers Emonkak\Validation\Constraint\GreaterThan
 */
class GreaterThanTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertContains('123', (new GreaterThan(123))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($criterion, $value, $expectedResult)
    {
        $constraint = new GreaterThan($criterion);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            [10, 0, false],
            [10, 1, false],
            [10, 9, false],
            [10, 10, false],
            [10, 11, true],
            [10, 20, true],
        ];
    }
}