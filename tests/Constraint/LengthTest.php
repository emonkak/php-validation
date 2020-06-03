<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Constraint\Length;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\Constraint\Length
 */
class LengthTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsInvalidArgumentException(): void
    {
        new Length(3, 1);
    }

    public function testGetDeclaration(): void
    {
        $this->assertNotEmpty((new Length(1, 3))->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult): void
    {
        $constraint = new Length(1, 3);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy(): array
    {
        return [
            ['', false],
            ['f', true],
            ['fo', true],
            ['foo', true],
            ['fooo', false],
        ];
    }
}
