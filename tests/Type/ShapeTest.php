<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Shape;
use Emonkak\Validation\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Type\Shape
 */
class ShapeTest extends TestCase
{
    public function testGetDeclaration(): void
    {
        $types = [
            'foo' => $this->createMock(TypeInterface::class)
        ];
        $shape = new Shape('Foo', $types);

        $this->assertSame('Foo', $shape->getDeclaration());
        $this->assertSame($types, $shape->getTypes());
    }

    public function testValidateReturnsTrue(): void
    {
        $key = 'foo';
        $value = [
            'bar' => 123,
            'baz' => 456,
        ];
        $shapeTypes = [
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class),
        ];

        $type = new Shape('Foo', $shapeTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $shapeTypes['bar']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key . '.bar'),
                $this->identicalTo($value['bar']),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $shapeTypes['baz']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key . '.baz'),
                $this->identicalTo($value['baz']),
                $this->identicalTo($collector)
            )
            ->willReturn(true);

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function testValidateReturnsFalse(): void
    {
        $key = 'foo';
        $value = [
            'bar' => 123,
            'baz' => 456,
        ];
        $shapeTypes = [
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class),
        ];

        $type = new Shape('Foo', $shapeTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $shapeTypes['bar']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key . '.bar'),
                $this->identicalTo($value['bar']),
                $this->identicalTo($collector)
            )
            ->willReturn(false);
        $shapeTypes['baz']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key . '.baz'),
                $this->identicalTo($value['baz']),
                $this->identicalTo($collector)
            )
            ->willReturn(false);

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function testValidateWilNull(): void
    {
        $key = 'foo';
        $value = null;
        $shapeTypes = [
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class),
        ];

        $type = new Shape('Foo', $shapeTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($type)
            );

        $shapeTypes['bar']
            ->expects($this->never())
            ->method('validate');
        $shapeTypes['baz']
            ->expects($this->never())
            ->method('validate');

        $this->assertFalse($type->validate($key, $value, $collector));
    }
}
