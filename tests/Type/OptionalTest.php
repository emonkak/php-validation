<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Optional;
use Emonkak\Validation\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\Type\Optional
 */
class OptionalTest extends TestCase
{
    public function testGetType(): void
    {
        $type = $this->createMock(TypeInterface::class);
        $optionalType = new Optional($type);

        $this->assertSame($type, $optionalType->getType());
    }

    /**
     * @dataProvider providerGetDeclaration
     */
    public function testGetDeclaration($declaration, $expectedDeclaration): void
    {
        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn($declaration);

        $this->assertSame($expectedDeclaration, (new Optional($type))->getDeclaration());
    }

    public function providerGetDeclaration(): array
    {
        return [
            ['integer', '?integer'],
            ['(integer|string)', '?(integer|string)'],
        ];
    }

    public function testValidateReturnsTrue(): void
    {
        $key = 'foo';
        $value = 123;

        $collector = $this->createMock(CollectorInterface::class);

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($collector)
            )
            ->willReturn(true);

        $optionalType = new Optional($type);

        $this->assertTrue($optionalType->validate($key, $value, $collector));
        $this->assertTrue($optionalType->validate($key, null, $collector));
    }

    public function testValidateReturnsFalse(): void
    {
        $key = 'foo';
        $value = 123;

        $collector = $this->createMock(CollectorInterface::class);

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($collector)
            )
            ->willReturn(false);

        $optionalType = new Optional($type);

        $this->assertFalse($optionalType->validate($key, $value, $collector));
    }
}
