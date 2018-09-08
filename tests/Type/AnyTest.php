<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Any;

/**
 * @covers Emonkak\Validation\Type\Any
 */
class AnyTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertSame('any', (new Any())->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($value)
    {
        $key = 'foo';
        $type = new Any();

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collectTypeError');

        $this->assertTrue($type->validate($key, $value, $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            [true],
            [false],
            ['foo'],
            [0],
            [1]
        ];
    }

    public function testValidateReturnsFalse()
    {
        $key = 'foo';
        $type = new Any();

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collectTypeError')
            ->with(
                $this->identicalTo($key),
                $this->identicalTo(null),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($key, null, $collector));
    }
}
