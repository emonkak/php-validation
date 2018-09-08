<?php

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\TypeError;
use Emonkak\Validation\Type\TypeInterface;

/**
 * @covers Emonkak\Validation\TypeError
 */
class TypeErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstrutor()
    {
        $key = 'key';
        $value = 'value';
        $type = $this->createMock(TypeInterface::class);
        $error = new TypeError($key, $value, $type);

        $this->assertSame($key, $error->getKey());
        $this->assertSame($value, $error->getValue());
        $this->assertSame($type, $error->getExpectedType());
    }

    public function testToString()
    {
        $key = 'key';
        $value = 'value';

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn('boolean');

        $error = new TypeError($key, $value, $type);

        $errorString = (string) $error;

        $this->assertContains("`$key`", $errorString);
        $this->assertContains('`string`', $errorString);
        $this->assertContains('`boolean`', $errorString);
    }
}
