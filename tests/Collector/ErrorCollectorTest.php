<?php

namespace Emonkak\Validation\Tests\Collector;

use Emonkak\Validation\Collector\ErrorCollector;
use Emonkak\Validation\Error;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\Collector\ErrorCollector
 */
class ErrorCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollect()
    {
        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn('string');

        $collector = new ErrorCollector();
        $collector->collect(true, 'foo', $type);

        $this->assertCount(1, $collector);
        $this->assertEquals(['foo' => [new Error('foo',  'string', 'boolean')]], $collector->getErrors());
        $this->assertEquals([new Error('foo',  'string', 'boolean')], $collector->toArray());
    }
}
