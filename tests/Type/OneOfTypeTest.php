<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\OneOfType;
use Emonkak\Validation\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Type\OneOfType
 */
class OneOfTypeTest extends TestCase
{
    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration(array $unionDeclarations, $expectedDeclaration): void
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

        $oneOfType = new OneOfType($types);

        $this->assertSame($expectedDeclaration, $oneOfType->getDeclaration());
        $this->assertSame($types, $oneOfType->getTypes());
    }

    public function providerGetDeclaration(): array
    {
        return [
            [['integer'], '(integer)'],
            [['integer', 'string'], '(integer|string)']
        ];
    }

    public function testValidateReturnsTrue(): void
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
            ->method('collectTypeError');

        $unionTypes[0]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(false);
        $unionTypes[1]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(true);

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function testValidateReturnsFalse(): void
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
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($type)
            );

        $unionTypes[0]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(false);
        $unionTypes[1]
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(false);

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function testUnion(): void
    {
        $type1 = $this->createMock(TypeInterface::class);
        $type2 = $this->createMock(TypeInterface::class);

        $oneOfType = new OneOfType([$type1]);
        $unionType = $oneOfType->union($type2);

        $this->assertInstanceOf(oneOfType::class, $unionType);
        $this->assertNotSame($oneOfType, $unionType);
        $this->assertSame([$type1, $type2], $unionType->getTypes());
    }
}
