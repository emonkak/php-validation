<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\ClassOf;

/**
 * @covers Emonkak\Validation\Type\ClassOf
 */
class ClassOfTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $class = \DateTime::class;
        $classOf = new ClassOf($class);

        $this->assertSame($class, $classOf->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($class, $value)
    {
        $key = 'foo';
        $type = new ClassOf($class);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            [\DateTime::class, new \DateTime()],
            [\DateTimeInterface::class, new \DateTime()],
            [\DateTimeInterface::class, new \DateTimeImmutable()]
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($class, $value)
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

    public function providerValidateReturnsFalse()
    {
        return [
            [\DateTime::class, new \DateTimeImmutable()],
            [\DateTimeImmutable::class, new \DateTime()],
            [\DateTimeInterface::class, null]
        ];
    }
}
