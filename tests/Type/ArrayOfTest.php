<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\ArrayOf;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\ArrayOf
 */
class ArrayOfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration($itemDeclaration, $expectedDeclaration)
    {
        $itemType = $this->createMock(TypeInterface::class);
        $itemType
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn($itemDeclaration);

        $this->assertSame($expectedDeclaration, (new ArrayOf($itemType))->getDeclaration());
    }

    public function providerGetDeclaration()
    {
        return [
            ['integer', 'integer[]'],
            ['integer|string', '(integer|string)[]']
        ];
    }

    public function testValidateReturnsTrue()
    {
        $value = [
            123,
            456,
            789
        ];
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new ArrayOf($itemType);

        $collector
            ->expects($this->never())
            ->method('collect');

        $itemType
            ->expects($this->at(0))
            ->method('validate')
            ->with(
                $this->identicalTo($value[0]),
                $this->identicalTo($key . '[0]'),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $itemType
            ->expects($this->at(1))
            ->method('validate')
            ->with(
                $this->identicalTo($value[1]),
                $this->identicalTo($key . '[1]'),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $itemType
            ->expects($this->at(2))
            ->method('validate')
            ->with(
                $this->identicalTo($value[2]),
                $this->identicalTo($key . '[2]'),
                $this->identicalTo($collector)
            )
            ->willReturn(true);

        $this->assertTrue($type->validate($value, $key, $collector));
    }

    public function testValidateReturnsFalse()
    {
        $value = [
            123,
            true,
            false
        ];
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new ArrayOf($itemType);

        $collector
            ->expects($this->never())
            ->method('collect');

        $itemType
            ->expects($this->at(0))
            ->method('validate')
            ->with(
                $this->identicalTo($value[0]),
                $this->identicalTo($key . '[0]'),
                $this->identicalTo($collector)
            )
            ->willReturn(true);
        $itemType
            ->expects($this->at(1))
            ->method('validate')
            ->with(
                $this->identicalTo($value[1]),
                $this->identicalTo($key . '[1]'),
                $this->identicalTo($collector)
            )
            ->willReturn(false);
        $itemType
            ->expects($this->at(2))
            ->method('validate')
            ->with(
                $this->identicalTo($value[2]),
                $this->identicalTo($key . '[2]'),
                $this->identicalTo($collector)
            )
            ->willReturn(false);

        $this->assertFalse($type->validate($value, $key, $collector));
    }

    public function testValidateWithNull()
    {
        $value = null;
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new ArrayOf($itemType);

        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($type)
            );

        $itemType
            ->expects($this->never())
            ->method('validate');

        $this->assertFalse($type->validate($value, $key, $collector));
    }
}
