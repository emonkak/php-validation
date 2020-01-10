<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Any;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Type\Any
 */
class AnyTest extends TestCase
{
    public function testGetDeclaration(): void
    {
        $this->assertSame('any', (new Any())->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($value): void
    {
        $key = 'foo';
        $type = new Any();

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsTrue(): array
    {
        return [
            [true],
            [false],
            ['foo'],
            [0],
            [1]
        ];
    }

    public function testValidateReturnsFalse(): void
    {
        $key = 'foo';
        $type = new Any();

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo(null),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($key, null, $collector));
    }
}
