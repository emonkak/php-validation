<?php

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\Error;

/**
 * @covers Emonkak\Validation\Error
 */
class ErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $error = new Error('foo', 'boolean', 'string');

        $this->assertNotEmpty((string) $error);
    }

    public function testGetKey()
    {
        $error = new Error('foo', 'boolean', 'string');

        $this->assertSame('foo', $error->getKey());
    }

    public function testGetExceptedType()
    {
        $error = new Error('foo', 'boolean', 'string');

        $this->assertSame('boolean', $error->getExceptedType());
    }

    public function testGetActualType()
    {
        $error = new Error('foo', 'boolean', 'string');

        $this->assertSame('string', $error->getActualType());
    }
}
