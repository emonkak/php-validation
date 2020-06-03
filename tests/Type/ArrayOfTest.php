<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\ArrayOf;
use Emonkak\Validation\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\Type\ArrayOf
 */
class ArrayOfTest extends TestCase
{
    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration($itemDeclaration, $expectedDeclaration): void
    {
        $itemType = $this->createMock(TypeInterface::class);
        $itemType
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn($itemDeclaration);

        $arrayOf = new ArrayOf($itemType);

        $this->assertSame($itemType, $arrayOf->getItemType());
        $this->assertSame($expectedDeclaration, $arrayOf->getDeclaration());
    }

    public function providerGetDeclaration(): array
    {
        return [
            ['integer', 'integer[]'],
            ['(integer|string)', '(integer|string)[]'],
        ];
    }

    public function testValidateReturnsTrue(): void
    {
        $key = 'foo';
        $value = [
            123,
            456,
            789,
        ];

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new ArrayOf($itemType);

        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $itemType
            ->expects($this->at(0))
            ->method('validate')
            ->with(
                $this->identicalTo($key . '[0]'),
                $this->identicalTo($value[0]),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $itemType
            ->expects($this->at(1))
            ->method('validate')
            ->with(
                $this->identicalTo($key . '[1]'),
                $this->identicalTo($value[1]),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $itemType
            ->expects($this->at(2))
            ->method('validate')
            ->with(
                $this->identicalTo($key . '[2]'),
                $this->identicalTo($value[2]),
                $this->identicalTo($collector)
            )
            ->willReturn(true);

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function testValidateReturnsFalse(): void
    {
        $key = 'foo';
        $value = [
            123,
            true,
            false,
        ];

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new ArrayOf($itemType);

        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $itemType
            ->expects($this->at(0))
            ->method('validate')
            ->with(
                $this->identicalTo($key . '[0]'),
                $this->identicalTo($value[0]),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $itemType
            ->expects($this->at(1))
            ->method('validate')
            ->with(
                $this->identicalTo($key . '[1]'),
                $this->identicalTo($value[1]),
                $this->identicalTo($collector)
            )
            ->willReturn(false);
        $itemType
            ->expects($this->at(2))
            ->method('validate')
            ->with(
                $this->identicalTo($key . '[2]'),
                $this->identicalTo($value[2]),
                $this->identicalTo($collector)
            )
            ->willReturn(false);

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function testValidateWithNull(): void
    {
        $key = 'foo';
        $value = null;

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new ArrayOf($itemType);

        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($type)
            );

        $itemType
            ->expects($this->never())
            ->method('validate');

        $this->assertFalse($type->validate($key, $value, $collector));
    }
}
