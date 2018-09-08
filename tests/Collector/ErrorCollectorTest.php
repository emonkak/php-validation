<?php

namespace Emonkak\Validation\Tests\Collector;

use Emonkak\Validation\Collector\ErrorCollector;
use Emonkak\Validation\ConstraintError;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\TypeError;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Collector\ErrorCollector
 */
class ErrorCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollectTypeError()
    {
        $key = 'key';
        $value = 'value';
        $type = $this->createMock(TypeInterface::class);

        $collector = new ErrorCollector();
        $collector->collectTypeError($key, $value, $type);

        $this->assertCount(1, $collector);
        $this->assertEquals([$key => [new TypeError($key, $value, $type)]], $collector->getErrors());
        $this->assertEquals([new TypeError($key, $value, $type)], $collector->toArray());
    }

    public function testCollectConstraintError()
    {
        $key = 'key';
        $value = 'value';
        $constraint = $this->createMock(ConstraintInterface::class);

        $collector = new ErrorCollector();
        $collector->collectConstraintError($key, $value, $constraint);

        $this->assertCount(1, $collector);
        $this->assertEquals([$key => [new ConstraintError($key, $value, $constraint)]], $collector->getErrors());
        $this->assertEquals([new ConstraintError($key, $value, $constraint)], $collector->toArray());
    }
}
