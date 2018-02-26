<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Shape;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\Shape
 */
class ShapeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertSame('Foo', (new Shape('Foo', []))->getDeclaration());
    }

    public function testValidateReturnsTrue()
    {
        $value = [
            'bar' => 123,
            'baz' => 456,
        ];
        $key = 'foo';
        $shapeTypes = [
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class),
        ];

        $type = new Shape('Foo', $shapeTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $shapeTypes['bar']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value['bar']),
                $this->identicalTo($key . '.bar'),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $shapeTypes['baz']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value['baz']),
                $this->identicalTo($key . '.baz'),
                $this->identicalTo($collector)
            )
            ->willReturn(true);

        $this->assertTrue($type->validate($value, $key, $collector));
    }

    public function testValidateReturnsFalse()
    {
        $value = [
            'bar' => 123,
            'baz' => 456,
        ];
        $key = 'foo';
        $shapeTypes = [
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class),
        ];

        $type = new Shape('Foo', $shapeTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $shapeTypes['bar']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value['bar']),
                $this->identicalTo($key . '.bar'),
                $this->identicalTo($collector)
            )
            ->willReturn(false);
        $shapeTypes['baz']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value['baz']),
                $this->identicalTo($key . '.baz'),
                $this->identicalTo($collector)
            )
            ->willReturn(false);

        $this->assertFalse($type->validate($value, $key, $collector));
    }

    public function testValidateWilNull()
    {
        $value = null;
        $key = 'foo';
        $shapeTypes = [
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class),
        ];

        $type = new Shape('Foo', $shapeTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($type)
            );

        $shapeTypes['bar']
            ->expects($this->never())
            ->method('validate');
        $shapeTypes['baz']
            ->expects($this->never())
            ->method('validate');

        $this->assertFalse($type->validate($value, $key, $collector));
    }
}
