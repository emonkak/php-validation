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
        $this->assertInstanceOf(Optional::class, (new OptionalTraitStub())->isOptional());
    }
}

class OptionalTraitStub implements TypeInterface
{
    use OptionalTrait;

    public function getDeclaration()
    {
        return 'string';
    }

    public function validate($value, $key, CollectorInterface $collector)
    {
        return true;
    }
}
