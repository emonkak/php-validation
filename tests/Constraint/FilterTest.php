<?php

namespace Emonkak\Validation\Tests\Constraint;

use Emonkak\Validation\Constraint\Filter;

/**
 * @covers Emonkak\Validation\Constraint\Filter
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorThrowsInvalidArgumentException()
    {
        new Filter('invalid');
    }

    public function testGetDeclaration()
    {
        $constraint = new Filter('int');

        $this->assertContains('int', $constraint->getDeclaration());
    }

    /**
     * @dataProvider providerValidateReturnsTrue
     */
    public function testIsSatisfiedByReturnsTrue($filter, $options, $value, $expectedResult)
    {
        $constraint = new Filter($filter, $options);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));

        $constraint = new Filter($filter, ['flags' => $options]);
        $this->assertSame($expectedResult, $constraint->isSatisfiedBy($value));
    }

    public function providerValidateReturnsTrue()
    {
        return [
            ['boolean', FILTER_NULL_ON_FAILURE, true, true],
            ['boolean', FILTER_NULL_ON_FAILURE, 'true', true],
            ['boolean', FILTER_NULL_ON_FAILURE, 'yes', true],
            ['boolean', FILTER_NULL_ON_FAILURE, 'on', true],
            ['boolean', FILTER_NULL_ON_FAILURE, 0, true],
            ['boolean', FILTER_NULL_ON_FAILURE, 1, true],
            ['boolean', FILTER_NULL_ON_FAILURE, '', true],
            ['boolean', FILTER_NULL_ON_FAILURE, '0', true],
            ['boolean', FILTER_NULL_ON_FAILURE, '1', true],
            ['int', 0, 0, true],
            ['int', 0, 1, true],
            ['int', 0, '0', true],
            ['int', 0, '1', true],
            ['float', 0, 1.0, true],
            ['float', 0, '1.0', true],
            ['boolean', FILTER_NULL_ON_FAILURE, 'foo', false],
            ['boolean', FILTER_NULL_ON_FAILURE, 100, false],
            ['int', null, 'foo', false],
            ['float', null, 'bar', false]
        ];
    }
}
