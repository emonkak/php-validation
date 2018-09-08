<?php

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\ErrorBagInterface;
use Emonkak\Validation\TypeError;
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
                $this->identicalTo('foo'),
                $this->identicalTo(123),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->willReturn(true);
        $types['bar']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo('bar'),
                $this->identicalTo(456),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->will($this->returnCallback(function($key, $value, $collector) use ($types) {
                $collector->collectTypeError($key, $value, $types['bar']);
            }));
        $types['baz']
            ->expects($this->once())
            ->method('validate')
            ->with(
                $this->identicalTo('baz'),
                $this->identicalTo(null),
                $this->isInstanceOf(CollectorInterface::class)
            )
            ->will($this->returnCallback(function($key, $value, $collector) use ($types) {
                $collector->collectTypeError($key, $value, $types['baz']);
            }));

        $data = [
            'foo' => 123,
            'bar' => 456
        ];

        $validator = new Validator($types);

        $errors = $validator->validate($data);

        $this->assertInstanceOf(ErrorBagInterface::class, $errors);
        $this->assertEquals([
            'bar' => [new TypeError('bar', 456, $types['bar'])],
            'baz' => [new TypeError('baz', null, $types['baz'])]
        ], $errors->getErrors());
    }
}
