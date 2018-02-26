<?php

namespace Emonkak\Validation\Tests\Collector;

use Emonkak\Validation\Collector\NullCollector;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Collector\NullCollector
 */
class NullCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollect()
    {
        $type = $this->createMock(TypeInterface::class);

        $collector = new NullCollector();
        $collector->collect(true, 'foo', $type);
    }
}
