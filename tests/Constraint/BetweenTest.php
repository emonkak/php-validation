<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\Between;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Constraint\Between
 */
class BetweenTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorThrowsInvalidArgumentException(): void
    {
        new Between(3, 1);
    }

    public function testGetDeclaration(): void
    {
        $this->assertNotEmpty((new Between(1, 3))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult): void
    {
        $constraint = new Between(1, 3);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy(): array
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
