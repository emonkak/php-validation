<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Optional;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\Optional
 */
class OptionalTest extends \PHPUnit_Framework_TestCase
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

        $this->assertSame($expectedDeclaration, (new Optional($itemType))->getDeclaration());
    }

    public function providerGetDeclaration()
    {
        return [
            ['integer', '?integer'],
            ['integer|string', '?(integer|string)']
        ];
    }

    public function testValidateReturnsTrue()
    {
        $value = 123;
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new Optional($itemType);

        $collector
            ->expects($this->never())
            ->method('collect');

        $itemType
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($collector)
            )
            ->willReturn(true);


        $this->assertTrue($type->validate($value, $key, $collector));
        $this->assertTrue($type->validate(null, $key, $collector));
    }

    public function testValidateReturnsFalse()
    {
        $value = 123;
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $itemType = $this->createMock(TypeInterface::class);
        $type = new Optional($itemType);

        $collector
            ->expects($this->never())
            ->method('collect');

        $itemType
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($collector)
            )
            ->willReturn(false);


        $this->assertFalse($type->validate($value, $key, $collector));
    }
}
