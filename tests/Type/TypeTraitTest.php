<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\Constrained;
use Emonkak\Validation\Type\OneOfType;
use Emonkak\Validation\Type\Optional;
use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Type\TypeTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Type\TypeTrait
 */
class TypeTraitTest extends TestCase
{
    public function testAllowEmpty(): void
    {
        $key = 'key';
        $type = new ConcreteTypeTrait();
        $emptyAllowedType = $type->allowEmpty();

        $collector = $this->createMock(CollectorInterface::class);

        $this->assertInstanceOf(TypeInterface::class, $emptyAllowedType);
        $this->assertTrue($emptyAllowedType->validate($key, null, $collector));
        $this->assertTrue($emptyAllowedType->validate($key, '', $collector));
        $this->assertFalse($emptyAllowedType->validate($key, 123, $collector));
    }

    public function testIsOptional(): void
    {
        $key = 'key';
        $type = new ConcreteTypeTrait();
        $optionalType = $type->isOptional();

        $collector = $this->createMock(CollectorInterface::class);

        $this->assertInstanceOf(TypeInterface::class, $optionalType);
        $this->assertTrue($optionalType->validate($key, null, $collector));
        $this->assertFalse($optionalType->validate($key, 123, $collector));
    }

    public function testWithConstraints(): void
    {
        $type = new ConcreteTypeTrait();

        $constraint = $this->createMock(ConstraintInterface::class);
        $constrainedType = $type->withConstraints($constraint);

        $this->assertInstanceOf(Constrained::class, $constrainedType);
        $this->assertSame($type, $constrainedType->getType());
        $this->assertSame([$constraint], $constrainedType->getConstraints());
    }

    public function testUnion(): void
    {
        $type = new ConcreteTypeTrait();
        $altType = $this->createMock(TypeInterface::class);
        $unionType = $type->union($altType);

        $this->assertInstanceOf(oneOfType::class, $unionType);
        $this->assertSame([$type, $altType], $unionType->getTypes());
    }
}

class ConcreteTypeTrait implements TypeInterface
{
    use TypeTrait;

    public function getDeclaration(): string
    {
        return 'string';
    }

    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        return false;
    }
}
