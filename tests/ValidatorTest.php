<?php

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Error;
use Emonkak\Validation\ErrorBagInterface;
use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Validator;

/**
 * @covers Emonkak\Validation\Validator
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidate()
    {
        $types = [
            'foo' => $this->createMock(TypeInterface::class),
            'bar' => $this->createMock(TypeInterface::class),
            'baz' => $this->createMock(TypeInterface::class)
        ];

        $types['foo']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo(123),
                $this->identicalTo('foo'),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(true);
        $types['bar']
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn('string');
        $types['bar']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo(456),
                $this->identicalTo('bar'),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->will($this->returnCallback(function($value, $key, $collector) use ($types) {
                $collector->collect($value, $key, $types['bar']);
            }));
        $types['baz']
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn('string');
        $types['baz']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo(null),
                $this->identicalTo('baz'),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->will($this->returnCallback(function($value, $key, $collector) use ($types) {
                $collector->collect($value, $key, $types['baz']);
            }));

        $data = [
            'foo' => 123,
            'bar' => 456
        ];

        $validator = new Validator($types);

        $errors = $validator->validate($data);

        $this->assertInstanceOf(ErrorBagInterface::class, $errors);
        $this->assertEquals([
            'bar' => [new Error('bar', 'string', 'integer')],
            'baz' => [new Error('baz', 'string', 'NULL')]
        ], $errors->getErrors());
    }
}
