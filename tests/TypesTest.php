<?php

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Types;

/**
 * @covers Emonkak\Validation\Types
 */
class TypesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerAny
     */
    public function testAny($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::any();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('any', $type->getDeclaration());
    }

    public function providerAny()
    {
        return [
            [true, 0],
            [true, 1],
            [true, ''],
            [true, 'foo'],
            [true, true],
            [true, false],
            [false, null]
        ];
    }

    /**
     * @dataProvider providerDate
     */
    public function testDate($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::date();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerDate()
    {
        return [
            [true, '2000-01-01'],
            [true, '2000-01-10'],
            [true, '2000-01-20'],
            [true, '2000-01-30'],
            [true, '2000-12-31'],
            [false, ''],
            [false, '2000-'],
            [false, '2000-'],
            [false, '2000-01'],
            [false, '2000-01-'],
            [false, '2000-01-00'],
            [false, '2000-01-32'],
            [false, '2000-00-01'],
        ];
    }

    /**
     * @dataProvider providerDateTime
     */
    public function testDateTime($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::dateTime();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerDateTime()
    {
        return [
            [true, '2000-01-01 00:00:00'],
            [true, '2000-01-10 00:00:00'],
            [true, '2000-01-20 00:00:00'],
            [true, '2000-01-30 00:00:00'],
            [true, '2000-12-31 00:00:00'],
            [false, ''],
            [false, '2000-'],
            [false, '2000-01'],
            [false, '2000-01-'],
            [false, '2000-01-00'],
            [false, '2000-01-32'],
            [false, '2000-00-01'],
            [false, '2000-10-01 24:00:00'],
        ];
    }

    /**
     * @dataProvider providerTime
     */
    public function testTime($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::time();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerTime()
    {
        return [
            [true, '00:00:00'],
            [true, '10:10:10'],
            [true, '23:59:59'],
            [false, '24:00:00'],
            [false, '00:60:00'],
            [false, '00:00:60'],
        ];
    }

    /**
     * @dataProvider providerString
     */
    public function testString($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::string();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('string', $type->getDeclaration());
    }

    public function providerString()
    {
        return [
            [true, ''],
            [true, 'foo'],
            [false, true],
            [false, false],
            [false, 1],
            [false, 0],
            [false, null],
        ];
    }

    /**
     * @dataProvider providerInt
     */
    public function testInt($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::int();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('integer', $type->getDeclaration());
    }

    public function providerInt()
    {
        return [
            [true, 1],
            [true, 1.0],
            [true, 0],
            [true, 0.0],
            [true, '1'],
            [true, '0'],
            [true, true],
            [false, 0.1],
            [false, 1.1],
            [false, ''],
            [false, 'foo'],
            [false, false],
            [false, null],
        ];
    }

    /**
     * @dataProvider providerIntValue
     */
    public function testIntValue($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::intValue();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('integer', $type->getDeclaration());
    }

    public function providerIntValue()
    {
        return [
            [true, 1],
            [true, 0],
            [false, '1'],
            [false, '0'],
            [false, true],
            [false, ''],
            [false, 'foo'],
            [false, false],
            [false, null],
        ];
    }

    /**
     * @dataProvider providerFloat
     */
    public function testFloat($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::float();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('double', $type->getDeclaration());
    }

    public function providerFloat()
    {
        return [
            [true, 1],
            [true, 1.0],
            [true, 0],
            [true, 0.0],
            [true, '1'],
            [true, '0'],
            [true, true],
            [true, 0.1],
            [true, 1.1],
            [false, ''],
            [false, 'foo'],
            [false, false],
            [false, null],
        ];
    }

    /**
     * @dataProvider providerFloatValue
     */
    public function testFloatValue($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::floatValue();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('double', $type->getDeclaration());
    }

    public function providerFloatValue()
    {
        return [
            [true, 0.0],
            [true, 0.1],
            [true, 1.0],
            [true, 1.1],
            [false, 1],
            [false, 0],
            [false, '1'],
            [false, '0'],
            [false, true],
            [false, ''],
            [false, 'foo'],
            [false, false],
            [false, null],
        ];
    }

    /**
     * @dataProvider providerBool
     */
    public function testBool($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::bool();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('boolean', $type->getDeclaration());
    }

    public function providerBool()
    {
        return [
            [true, 1],
            [true, 1.0],
            [true, 0],
            [true, 0.0],
            [true, ''],
            [true, '1'],
            [true, '0'],
            [true, true],
            [true, false],
            [true, null],
            [false, 0.1],
            [false, 1.1],
            [false, 'foo'],
        ];
    }

    /**
     * @dataProvider providerBoolValue
     */
    public function testBoolValue($expectedResult, $value)
    {
        $key = 'key';
        $type = Types::boolValue();
        $this->assertSame($expectedResult, $type->validate($key, $value, $this->createMock(CollectorInterface::class)));
        $this->assertSame('boolean', $type->getDeclaration());
    }

    public function providerBoolValue()
    {
        return [
            [true, true],
            [true, false],
            [false, 0.0],
            [false, 0.1],
            [false, 1.0],
            [false, 1.1],
            [false, 1],
            [false, 0],
            [false, '1'],
            [false, '0'],
            [false, ''],
            [false, 'foo'],
            [false, null],
        ];
    }

    public function testArrayOf()
    {
        $key = 'key';
        $type = Types::arrayOf(Types::intValue());

        $this->assertTrue($type->validate($key, [], $this->createMock(CollectorInterface::class)));
        $this->assertTrue($type->validate($key, [1, 2, 3], $this->createMock(CollectorInterface::class)));
        $this->assertFalse($type->validate($key, [1, '2', 3], $this->createMock(CollectorInterface::class)));

        $this->assertSame('integer[]', $type->getDeclaration());
    }

    public function testClassOf()
    {
        $key = 'key';
        $type = Types::classOf(\DateTime::class);

        $this->assertTrue($type->validate($key, new \DateTime(), $this->createMock(CollectorInterface::class)));
        $this->assertFalse($type->validate($key, new \DateTimeImmutable(), $this->createMock(CollectorInterface::class)));

        $this->assertSame(\DateTime::class, $type->getDeclaration());
    }

    public function testOneOf()
    {
        $key = 'key';
        $type = Types::oneOf(['foo', 'bar']);

        $this->assertTrue($type->validate($key, 'foo', $this->createMock(CollectorInterface::class)));
        $this->assertTrue($type->validate($key, 'bar', $this->createMock(CollectorInterface::class)));
        $this->assertFalse($type->validate($key, 'baz', $this->createMock(CollectorInterface::class)));

        $this->assertSame('("foo"|"bar")', $type->getDeclaration());
    }

    public function testOneOfType()
    {
        $key = 'key';
        $type = Types::oneOfType([Types::intValue(), Types::string()]);

        $this->assertTrue($type->validate($key, 0, $this->createMock(CollectorInterface::class)));
        $this->assertTrue($type->validate($key, 'foo', $this->createMock(CollectorInterface::class)));
        $this->assertFalse($type->validate($key, true, $this->createMock(CollectorInterface::class)));

        $this->assertSame('(integer|string)', $type->getDeclaration());
    }

    public function testShape()
    {
        $key = 'key';
        $type = Types::shape('Foo', [
            'foo' => Types::intValue(),
            'bar' => Types::boolValue(),
        ]);

        $this->assertTrue($type->validate($key, ['foo' => 1, 'bar' => true], $this->createMock(CollectorInterface::class)));
        $this->assertFalse($type->validate($key, ['foo' => '1', 'bar' => true], $this->createMock(CollectorInterface::class)));
        $this->assertFalse($type->validate($key, ['foo' => 1, 'bar' => 'true'], $this->createMock(CollectorInterface::class)));

        $this->assertSame('Foo', $type->getDeclaration());
    }
}
