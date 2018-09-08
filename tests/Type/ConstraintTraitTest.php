<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\Constrained;
use Emonkak\Validation\Type\ConstraintTrait;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\ConstraintTrait
 */
class ConstraintTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testWithConstraints()
    {
        $type = new ConcreteConstraintTrait();

        $constraint = $this->createMock(ConstraintInterface::class);
        $constrainedType = $type->withConstraints($constraint);

        $this->assertInstanceOf(Constrained::class, $constrainedType);
        $this->assertSame($type, $constrainedType->getType());
        $this->assertSame([$constraint], $constrainedType->getConstraints());
    }
}

class ConcreteConstraintTrait implements TypeInterface
{
    use ConstraintTrait;

    public function getDeclaration()
    {
        return 'string';
    }

    public function validate($key, $value, CollectorInterface $collector)
    {
        return true;
    }
}
