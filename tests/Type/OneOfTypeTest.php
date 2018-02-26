<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\OneOfType;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\OneOfType
 */
class OneOfTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration(array $unionDeclarations, $expectedDeclaration)
    {
        $types = [];

        foreach ($unionDeclarations as $unionDeclaration) {
            $type = $this->createMock(TypeInterface::class);
            $type
                ->expects($this->once())
                ->method('getDeclaration')
                ->willReturn($unionDeclaration);
            $types[] = $type;
        }

        $this->assertSame($expectedDeclaration, (new OneOfType($types))->getDeclaration());
    }

    public function providerGetDeclaration()
    {
        return [
            [['integer'], 'integer'],
            [['integer', 'string'], 'integer|string']
        ];
    }

    public function testValidateReturnsTrue()
    {
        $key = 'foo';
        $value = 'bar';

        $unionTypes = [
            $this->createMock(TypeInterface::class),
            $this->createMock(TypeInterface::class)
        ];
        $type = new OneOfType($unionTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $unionTypes[0]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(false);
        $unionTypes[1]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(true);

        $this->assertTrue($type->validate($value, $key, $collector));
    }

    public function testValidateReturnsFalse()
    {
        $key = 'foo';
        $value = 'bar';

        $unionTypes = [
            $this->createMock(TypeInterface::class),
            $this->createMock(TypeInterface::class)
        ];
        $type = new OneOfType($unionTypes);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($type)
            );

        $unionTypes[0]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(false);
        $unionTypes[1]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(false);

        $this->assertFalse($type->validate($value, $key, $collector));
    }
}
