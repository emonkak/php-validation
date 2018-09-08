<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\Constrained;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\Constrained
 */
class ConstrainedTest extends \PHPUnit_Framework_TestCase
{
    public function testConstrutor()
    {
        $type = $this->createMock(TypeInterface::class);
        $constraints = [$this->createMock(ConstraintInterface::class)];
        $optionalType = new Constrained($type, $constraints);

        $this->assertSame($type, $optionalType->getType());
        $this->assertSame($constraints, $optionalType->getConstraints());
    }

    public function testGetDeclaration()
    {
        $declaration = 'declaration';

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn($declaration);

        $this->assertSame($declaration, (new Constrained($type, []))->getDeclaration());
    }

    public function testValidateReturnsTrue()
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

        $constraints = [
            $this->createMock(ConstraintInterface::class),
            $this->createMock(ConstraintInterface::class),
        ];
        $constraints[0]
            ->expects($this->once())
            ->method('isSatisfiedBy')
            ->with($this->identicalTo($value))
            ->willReturn(true);
        $constraints[1]
            ->expects($this->once())
            ->method('isSatisfiedBy')
            ->with($this->identicalTo($value))
            ->willReturn(true);

        $type = new Constrained($type, $constraints);

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function testValidateFailsTypeValidation()
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

        $constraints = [
            $this->createMock(ConstraintInterface::class),
            $this->createMock(ConstraintInterface::class),
        ];
        $constraints[0]
            ->expects($this->never())
            ->method('isSatisfiedBy');
        $constraints[1]
            ->expects($this->never())
            ->method('isSatisfiedBy');

        $type = new Constrained($type, $constraints);

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function testValidateFailsConstraintValidation()
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

        $constraints = [
            $this->createMock(ConstraintInterface::class),
            $this->createMock(ConstraintInterface::class),
        ];
        $constraints[0]
            ->expects($this->once())
            ->method('isSatisfiedBy')
            ->with($this->identicalTo($value))
            ->willReturn(true);
        $constraints[1]
            ->expects($this->once())
            ->method('isSatisfiedBy')
            ->with($this->identicalTo($value))
            ->willReturn(false);

        $type = new Constrained($type, $constraints);

        $this->assertFalse($type->validate($key, $value, $collector));
    }

    public function testWithConstraints()
    {
        $type = $this->createMock(TypeInterface::class);
        $constraints = [
            $this->createMock(ConstraintInterface::class),
            $this->createMock(ConstraintInterface::class),
            $this->createMock(ConstraintInterface::class),
        ];

        $this->assertSame(
            $constraints,
            (new Constrained($type, [$constraints[0]]))
                ->withConstraints($constraints[1], $constraints[2])
                ->getConstraints()
        );
    }
}
