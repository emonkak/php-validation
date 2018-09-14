<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\Constrained;
use Emonkak\Validation\Type\Optional;
use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Type\TypeTrait;

/**
 * @covers Emonkak\Validation\Type\TypeTrait
 */
class TypeTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testIsOptional()
    {
        $type = new ConcreteTypeTrait();
        $optionalType = $type->isOptional();

        $this->assertInstanceOf(Optional::class, $optionalType);
        $this->assertSame($type, $optionalType->getType());
    }

    public function testWithConstraints()
    {
        $type = new ConcreteTypeTrait();

        $constraint = $this->createMock(ConstraintInterface::class);
        $constrainedType = $type->withConstraints($constraint);

        $this->assertInstanceOf(Constrained::class, $constrainedType);
        $this->assertSame($type, $constrainedType->getType());
        $this->assertSame([$constraint], $constrainedType->getConstraints());
    }
}

class ConcreteTypeTrait implements TypeInterface
{
    use TypeTrait;

    public function getDeclaration()
    {
        return 'string';
    }

    public function validate($key, $value, CollectorInterface $collector)
    {
        return true;
    }
}
