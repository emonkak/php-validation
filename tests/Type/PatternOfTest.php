<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\PatternOf;

class PatternOfTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertSame('Foo', (new PatternOf('Foo', '//'))->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($declaration, $pattern, $value)
    {
        $type = new PatternOf($declaration, $pattern);
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $this->assertTrue($type->validate($value, $key, $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            ['Foo', '//', ''],
            ['Foo', '/^foo$/', 'foo'],
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($declaration, $pattern, $value)
    {
        $type = new PatternOf($declaration, $pattern);
        $key = 'foo';

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo($key),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($value, $key, $collector));
    }

    public function providerValidateReturnsFalse()
    {
        return [
            ['Foo', '//', 0],
            ['Foo', '//', null],
            ['Foo', '/^foo$/', 'bar'],
        ];
    }
}
