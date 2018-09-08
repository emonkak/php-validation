<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\Matches;

/**
 * @covers Emonkak\Validation\Constraint\Matches
 */
class MatchesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $pattern = '/.*/';
        $this->assertContains($pattern, (new Matches($pattern))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($pattern, $value, $expectedResult)
    {
        $constraint = new Matches($pattern);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy()
    {
        return [
            ['//', '', true],
            ['/^foo$/', 'foo', true],
            ['/^foo$/', 'bar', false],
        ];
    }
}
