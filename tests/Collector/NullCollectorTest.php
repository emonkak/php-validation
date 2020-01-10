<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests\Collector;

use Emonkak\Validation\Collector\NullCollector;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\Collector\NullCollector
 */
class NullCollectorTest extends TestCase
{
    public function testCollectTypeError(): void
    {
        $key = 'key';
        $value = 'value';
        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->never())
            ->method('validate');

        $collector = new NullCollector();
        $collector->collectTypeError($key, $value, $type);
    }

    public function testCollectConstraintError(): void
    {
        $key = 'key';
        $value = 'value';
        $constraint = $this->createMock(ConstraintInterface::class);
        $constraint
            ->expects($this->never())
            ->method('isSatisfiedBy');

        $collector = new NullCollector();
        $collector->collectConstraintError($key, $value, $constraint);
    }
}
