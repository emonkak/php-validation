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
        $this->assertSame(\DateTime::class, (new ClassOf(\DateTime::class))->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($class, $value)
    {
        $type = new ClassOf($class);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $this->assertTrue($type->validate($value, 'foo', $collector));
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
        $type = new ClassOf($class);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo('foo'),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($value, 'foo', $collector));
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
