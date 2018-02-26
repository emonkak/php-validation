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
        $type = new Any();

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $this->assertTrue($type->validate($value, 'foo', $collector));
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
        $type = new Any();

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo(null),
                $this->identicalTo('foo'),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate(null, 'foo', $collector));
    }
}
