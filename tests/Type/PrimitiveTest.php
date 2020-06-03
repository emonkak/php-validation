<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Primitive;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\Type\Primitive
 */
class PrimitiveTest extends TestCase
{
    public function testGetDeclaration(): void
    {
        $this->assertSame('string', (new Primitive('string'))->getDeclaration());
        $this->assertSame('integer', (new Primitive('integer'))->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue(string $declaration, $value): void
    {
        $key = 'foo';
        $type = new Primitive($declaration);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsTrue(): array
    {
        return [
            ['string', ''],
            ['string', 'foo'],
            ['string', 'bar'],
            ['integer', 0],
            ['integer', 1],
            ['double', 0.0],
            ['double', 1.0],
            ['boolean', true],
            ['boolean', false],
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse(string $declaration, $value): void
    {
        $key = 'foo';
        $type = new Primitive($declaration);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo('foo'),
                $this->identicalTo($value),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsFalse(): array
    {
        return [
            ['string', true],
            ['string', false],
            ['string', 1],
            ['string', 0],
        ];
    }
}
