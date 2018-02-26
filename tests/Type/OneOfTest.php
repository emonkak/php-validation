<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\OneOf;

/**
 * @covers Emonkak\Validation\Type\OneOf
 */
class OneOfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration(array $expectedValues, $expectedDeclaration)
    {
        $this->assertSame($expectedDeclaration, (new OneOf($expectedValues))->getDeclaration());
    }

    public function providerGetDeclaration()
    {
        return [
            [['foo'], '"foo"'],
            [['foo', 'bar'], '"foo"|"bar"']
        ];
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($value, array $expectedValues)
    {
        $key = 'foo';
        $type = new OneOf($expectedValues);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');


        $this->assertTrue($type->validate($value, $key, $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            [123, [123, 456]],
            [456, [123, 456]]
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($value, array $expectedValues)
    {
        $key = 'foo';
        $type = new OneOf($expectedValues);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($value, $key, $collector));
    }

    public function providerValidateReturnsFalse()
    {
        return [
            [123, []],
            ['foo', [123, 456]],
            [null, [123, 456]]
        ];
    }
}
