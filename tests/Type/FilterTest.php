<?php

namespace Emonkak\Validation\Tests\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Type\Filter;

/**
 * @covers Emonkak\Validation\Type\Filter
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDeclaration()
    {
        $this->assertSame('boolean', (new Filter('boolean', FILTER_VALIDATE_BOOLEAN))->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testValidateReturnsTrue($declaration, $filter, $options, $value)
    {
        $type = new Filter($declaration, $filter, $options);

        $collector = $this->createMock(CollectorInterface::class);
        $collector
            ->expects($this->never())
            ->method('collect');

        $this->assertTrue($type->validate($value, 'foo', $collector));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, true],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 'true'],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 'yes'],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 'on'],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 0],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 1],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, ''],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, '0'],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, '1'],
            ['integer', FILTER_VALIDATE_INT, 0, 0],
            ['integer', FILTER_VALIDATE_INT, 0, 1],
            ['integer', FILTER_VALIDATE_INT, 0, '0'],
            ['integer', FILTER_VALIDATE_INT, 0, '1'],
            ['double', FILTER_VALIDATE_FLOAT, 0, 1.0],
            ['double', FILTER_VALIDATE_FLOAT, 0, '1.0']
        ];
    }

    /**
     * @dataProvider providerValidateReturnsFalse
     */
    public function testValidateReturnsFalse($declaration, $filter, $options, $value)
    {
        $type = new Filter($declaration, $filter, $options);

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
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 'foo'],
            ['boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE, 100],
            ['integer', FILTER_VALIDATE_INT, 0, 'foo'],
            ['double', FILTER_VALIDATE_FLOAT, 0, 'bar']
        ];
    }
}
