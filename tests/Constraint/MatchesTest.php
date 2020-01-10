<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\Matches;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Constraint\Matches
 */
class MatchesTest extends TestCase
{
    public function testGetDeclaration(): void
    {
        $pattern = '/.*/';
        $this->assertContains($pattern, (new Matches($pattern))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($pattern, $value, $expectedResult): void
    {
        $constraint = new Matches($pattern);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy(): array
    {
        return [
            ['//', '', true],
            ['/^foo$/', 'foo', true],
            ['/^foo$/', 'bar', false],
        ];
    }
}
