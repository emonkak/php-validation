<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\OneOf;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Type\OneOf
 */
class OneOfTest extends TestCase
{
    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration(array $expectedValues, $expectedDeclaration)
    {
        $oneOf = new OneOf($expectedValues, true);

        $this->assertSame($expectedDeclaration, $oneOf->getDeclaration());
        $this->assertSame($expectedValues, $oneOf->getExpectedValues());
    }

    public function providerGetDeclaration()
    {
        return [
            [['foo'], '("foo")'],
            [['foo', 'bar'], '("foo"|"bar")']
        ];
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($value, array $expectedValues, $strict)
    {
        $key = 'foo';
        $type = new OneOf($expectedValues, $strict);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            [123, [123, 456], true],
            [456, [123, 456], true],
            ['123', [123, 456], false],
            ['456', [123, 456], false]
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($value, array $expectedValues, $strict)
    {
        $key = 'foo';
        $type = new OneOf($expectedValues, $strict);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsFalse()
    {
        return [
            [123, [], true],
            ['123', [123], true],
            ['foo', [123, 456], true],
            [null, [123, 456], true]
        ];
    }
}
