<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Types;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Types
 */
class TypesTest extends TestCase
{
    /**
     * @dataProvider providerAny
     */
    public function testAny($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::any();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('any', $type->getDeclaration());
    }

    public function providerAny(): array
    {
        return [
            [0, true],
            [1, true],
            ['', true],
            ['foo', true],
            [true, true],
            [false, true],
            [null, false]
        ];
    }

    /**
     * @dataProvider providerArray
     */
    public function testArray($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::array();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('array', $type->getDeclaration());
    }

    public function providerArray(): array
    {
        return [
            [0, false],
            [1, false],
            ['', false],
            ['foo', false],
            [true, false],
            [false, false],
            [null, false],
            [[], true]
        ];
    }

    /**
     * @dataProvider providerDate
     */
    public function testDate($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::date();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerDate(): array
    {
        return [
            ['2000-01-01', true],
            ['2000-01-10', true],
            ['2000-01-20', true],
            ['2000-01-30', true],
            ['2000-12-31', true],
            ['', false],
            ['2000-', false],
            ['2000-', false],
            ['2000-01', false],
            ['2000-01-', false],
            ['2000-01-00', false],
            ['2000-01-32', false],
            ['2000-00-01', false],
        ];
    }

    /**
     * @dataProvider providerDateTime
     */
    public function testDateTime($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::dateTime();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerDateTime(): array
    {
        return [
            ['2000-01-01 00:00:00', true],
            ['2000-01-10 00:00:00', true],
            ['2000-01-20 00:00:00', true],
            ['2000-01-30 00:00:00', true],
            ['2000-12-31 00:00:00', true],
            ['', false],
            ['2000-', false],
            ['2000-01', false],
            ['2000-01-', false],
            ['2000-01-00', false],
            ['2000-01-32', false],
            ['2000-00-01', false],
            ['2000-10-01 24:00:00', false],
        ];
    }

    /**
     * @dataProvider providerTime
     */
    public function testTime($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::time();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerTime(): array
    {
        return [
            ['00:00:00', true],
            ['10:10:10', true],
            ['23:59:59', true],
            ['24:00:00', false],
            ['00:60:00', false],
            ['00:00:60', false],
        ];
    }

    /**
     * @dataProvider providerString
     */
    public function testString($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::string();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerString(): array
    {
        return [
            ['', true],
            ['foo', true],
            [true, false],
            [false, false],
            [1, false],
            [0, false],
            [null, false],
        ];
    }

    /**
     * @dataProvider providerStringLength
     */
    public function testStringLength($value, int $minLength, int $maxLength, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::string($minLength, $maxLength);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerStringLength(): array
    {
        return [
            ['', 1, 3, false],
            ['f', 1, 3, true],
            ['fo', 1, 3, true],
            ['foo', 1, 3, true],
            ['fooo', 1, 3, false],
        ];
    }

    /**
     * @dataProvider providerInt
     */
    public function testInt($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::int();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('integer', $type->getDeclaration());
    }

    public function providerInt(): array
    {
        return [
            [1, true],
            [0, true],
            ['1', false],
            ['0', false],
            [true, false],
            ['', false],
            ['foo', false],
            [false, false],
            [null, false],
        ];
    }

    /**
     * @dataProvider providerIntBetween
     */
    public function testIntBetween($value, int $min, int $max, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::int($min, $max);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('integer', $type->getDeclaration());
    }

    public function providerIntBetween(): array
    {
        return [
            [0, 1, 3, false],
            [1, 1, 3, true],
            [2, 1, 3, true],
            [3, 1, 3, true],
            [4, 1, 3, false],
            ['0', 1, 3, false],
            ['1', 1, 3, false],
            ['2', 1, 3, false],
            ['3', 1, 3, false],
            ['4', 1, 3, false],
        ];
    }

    /**
     * @dataProvider providerFloat
     */
    public function testFloat($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::float();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('double', $type->getDeclaration());
    }

    public function providerFloat(): array
    {
        return [
            [0.0, true],
            [0.1, true],
            [1.0, true],
            [1.1, true],
            [1, false],
            [0, false],
            ['1', false],
            ['0', false],
            [true, false],
            ['', false],
            ['foo', false],
            [false, false],
            [null, false],
        ];
    }

    /**
     * @dataProvider providerFloatBetween
     */
    public function testFloatBetween($value, float $min, float $max, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::float($min, $max);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('double', $type->getDeclaration());
    }

    public function providerFloatBetween(): array
    {
        return [
            [0.0, 1, 3, false],
            [1.0, 1, 3, true],
            [2.0, 1, 3, true],
            [3.0, 1, 3, true],
            [4.0, 1, 3, false],
            ['0.0', 1, 3, false],
            ['1.0', 1, 3, false],
            ['2.0', 1, 3, false],
            ['3.0', 1, 3, false],
            ['4.0', 1, 3, false],
        ];
    }

    /**
     * @dataProvider providerBool
     */
    public function testBool($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::bool();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('boolean', $type->getDeclaration());
    }

    public function providerBool(): array
    {
        return [
            [true, true],
            [false, true],
            [0.0, false],
            [0.1, false],
            [1.0, false],
            [1.1, false],
            [1, false],
            [0, false],
            ['1', false],
            ['0', false],
            ['', false],
            ['foo', false],
            [null, false],
        ];
    }

    /**
     * @dataProvider providerDigit
     */
    public function testDigit($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::digit();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('any', $type->getDeclaration());
    }

    public function providerDigit(): array
    {
        return [
            [1, true],
            [1.0, true],
            [0, true],
            [0.0, true],
            ['1', true],
            ['0', true],
            [true, true],
            [0.1, false],
            [1.1, false],
            ['', false],
            ['foo', false],
            [false, false],
            [null, false],
        ];
    }

    /**
     * @dataProvider providerDecimal
     */
    public function testDecimal($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::decimal();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('any', $type->getDeclaration());
    }

    public function providerDecimal(): array
    {
        return [
            [1, true],
            [1.0, true],
            [0, true],
            [0.0, true],
            ['1', true],
            ['0', true],
            [true, true],
            [0.1, true],
            [1.1, true],
            ['', false],
            ['foo', false],
            [false, false],
            [null, false],
        ];
    }

    /**
     * @dataProvider providerAccepted
     */
    public function testAccepted($value, bool $expectedResult): void
    {
        $key = 'key';
        $type = Types::accepted();
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertSame($expectedResult, $type->validate($key, $value, $collector));
        $this->assertSame('any', $type->getDeclaration());
    }

    public function providerAccepted(): array
    {
        return [
            [1, true],
            [1.0, true],
            [0, true],
            [0.0, true],
            ['', true],
            ['1', true],
            ['0', true],
            [true, true],
            [false, true],
            [null, false],
            [0.1, false],
            [1.1, false],
            ['foo', false],
        ];
    }

    public function testArrayOf(): void
    {
        $key = 'key';
        $type = Types::arrayOf(Types::int());
        $collector = $this->createMock(CollectorInterface::class);


        $this->assertTrue($type->validate($key, [], $collector));
        $this->assertTrue($type->validate($key, [1, 2, 3], $collector));
        $this->assertFalse($type->validate($key, [1, '2', 3], $collector));

        $this->assertSame('integer[]', $type->getDeclaration());
    }

    public function testClassOf(): void
    {
        $key = 'key';
        $type = Types::classOf(\DateTime::class);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertTrue($type->validate($key, new \DateTime(), $collector));
        $this->assertFalse($type->validate($key, new \DateTimeImmutable(), $collector));

        $this->assertSame(\DateTime::class, $type->getDeclaration());
    }

    public function testOneOf(): void
    {
        $key = 'key';
        $type = Types::oneOf(['foo', 'bar']);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertTrue($type->validate($key, 'foo', $collector));
        $this->assertTrue($type->validate($key, 'bar', $collector));
        $this->assertFalse($type->validate($key, 'baz', $collector));

        $this->assertSame('("foo"|"bar")', $type->getDeclaration());
    }

    public function testOneOfType(): void
    {
        $key = 'key';
        $type = Types::oneOfType([Types::int(), Types::string()]);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertTrue($type->validate($key, 0, $collector));
        $this->assertTrue($type->validate($key, 'foo', $collector));
        $this->assertFalse($type->validate($key, true, $collector));

        $this->assertSame('(integer|string)', $type->getDeclaration());
    }

    public function testShape(): void
    {
        $key = 'key';
        $type = Types::shape('Foo', [
            'foo' => Types::int(),
            'bar' => Types::bool(),
        ]);
        $collector = $this->createMock(CollectorInterface::class);

        $this->assertTrue($type->validate($key, ['foo' => 1, 'bar' => true], $collector));
        $this->assertFalse($type->validate($key, ['foo' => '1', 'bar' => true], $collector));
        $this->assertFalse($type->validate($key, ['foo' => 1, 'bar' => 'true'], $collector));

        $this->assertSame('Foo', $type->getDeclaration());
    }
}
