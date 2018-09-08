<?php

namespace Emonkak\Validation\Tests\Collector;

use Emonkak\Validation\Collector\NullCollector;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Collector\NullCollector
 */
class NullCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollectTypeError()
    {
        $key = 'key';
        $value = 'value';
        $type = $this->createMock(TypeInterface::class);

        $collector = new NullCollector();
        $collector->collectTypeError($key, $value, $type);
    }

    public function testCollectConstraintError()
    {
        $key = 'key';
        $value = 'value';
        $constraint = $this->createMock(ConstraintInterface::class);

        $collector = new NullCollector();
        $collector->collectConstraintError($key, $value, $constraint);
    }
}
