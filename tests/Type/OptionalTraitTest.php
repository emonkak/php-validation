<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Optional;
use Emonkak\Validation\Type\OptionalTrait;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Type\OptionalTrait
 */
class OptionalTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testIsOptional()
    {
        $type = new ConcreteOptionalTrait();
        $optionalType = $type->isOptional();

        $this->assertInstanceOf(Optional::class, $optionalType);
        $this->assertSame($type, $optionalType->getType());
    }
}

class ConcreteOptionalTrait implements TypeInterface
{
    use OptionalTrait;

    public function getDeclaration()
    {
        return 'string';
    }

    public function validate($key, $value, CollectorInterface $collector)
    {
        return true;
    }
}
