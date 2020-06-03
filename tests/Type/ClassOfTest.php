<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\ClassOf;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\Type\ClassOf
 */
class ClassOfTest extends TestCase
{
    public function testGetDeclaration(): void
    {
        $class = \DateTime::class;
        $classOf = new ClassOf($class);

        $this->assertSame($class, $classOf->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($class, $value): void
    {
        $key = 'foo';
        $type = new ClassOf($class);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsTrue(): array
    {
        return [
            [\DateTime::class, new \DateTime()],
            [\DateTimeInterface::class, new \DateTime()],
            [\DateTimeInterface::class, new \DateTimeImmutable()],
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($class, $value): void
    {
        $key = 'foo';
        $type = new ClassOf($class);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo($value),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsFalse(): array
    {
        return [
            [\DateTime::class, new \DateTimeImmutable()],
            [\DateTimeImmutable::class, new \DateTime()],
            [\DateTimeInterface::class, null],
        ];
    }
}
