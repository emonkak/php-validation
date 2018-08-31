<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Primitive;

/**
 * @covers Emonkak\Validation\Type\Primitive
 */
class StrTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertSame('string', (new Primitive('string'))->getDeclaration());
        $this->assertSame('integer', (new Primitive('integer'))->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($declaration, $value)
    {
        $type = new Primitive($declaration);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $this->assertTrue($type->validate($value, 'foo', $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            ['string', ''],
            ['string', 'foo'],
            ['string', 'bar'],
            ['integer', 0],
            ['integer', 1],
            ['double', 0.0],
            ['double', 1.0],
            ['boolean', true],
            ['boolean', false],
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($declaration, $value)
    {
        $type = new Primitive($declaration);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->once())
            ->method('collect')
            ->with(
                $this->identicalTo($value),
                $this->identicalTo('foo'),
                $this->identicalTo($type)
            );

        $this->assertFalse($type->validate($value, 'foo', $collector));
    }

    public function providerValidateReturnsFalse()
    {
        return [
            ['string', true],
            ['string', false],
            ['string', 1],
            ['string', 0]
        ];
    }
}