<?php

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\ConstraintError;
use Emonkak\Validation\Constraint\ConstraintInterface;

/**
 * @covers Emonkak\Validation\ConstraintError
 */
class ConstraintErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstrutor()
    {
        $key = 'key';
        $value = 'value';
        $constraint = $this->createMock(ConstraintInterface::class);
        $error = new ConstraintError($key, $value, $constraint);

        $this->assertSame($key, $error->getKey());
        $this->assertSame($value, $error->getValue());
        $this->assertSame($constraint, $error->getConstraint());
    }

    public function testToString()
    {
        $key = 'key';
        $value = 'value';

        $constraint = $this->createMock(ConstraintInterface::class);
        $constraint
            ->expects($this->once())
            ->method('getDeclaration')
            ->willReturn('my_constraint');

        $error = new ConstraintError($key, $value, $constraint);

        $errorString = (string) $error;

        $this->assertContains("`$key`", $errorString);
        $this->assertContains('`my_constraint`', $errorString);
        $this->assertContains("`'value'`", $errorString);
    }
}
