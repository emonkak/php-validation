<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Constraint\DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\Constraint\DateTime
 */
class DateTimeTest extends TestCase
{
    public function testGetDeclaration(): void
    {
        $this->assertNotEmpty((new DateTime())->getDeclaration());
    }

    /**
     * @dataProvider providerIsSatisfiedBy
     */
    public function testIsSatisfiedBy($value, $expectedResult): void
    {
        $this->assertSame($expectedResult, (new DateTime())->isSatisfiedBy($value));
    }

    public function providerIsSatisfiedBy(): array
    {
        return [
            ['', false],
            ['2000-01-02', true],
            ['2000-01-02 03:04:05', true],
            ['2000-01-02T03:04:05', true],
            ['2000-01-02T03:04:05+09:00', true],
            ['2000-01-02T03:04:05Z', true],
            ['2000-01-00', false],
            ['2000-01-32', false],
        ];
    }
}
