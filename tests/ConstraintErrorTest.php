<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\ConstraintError;
use Emonkak\Validation\Constraint\ConstraintInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Validation\ConstraintError
 */
class ConstraintErrorTest extends TestCase
{
    public function testConstrutor(): void
    {
        $key = 'key';
        $value = 'value';
        $constraint = $this->createMock(ConstraintInterface::class);
        $error = new ConstraintError($key, $value, $constraint);

        $this->assertSame($key, $error->getKey());
        $this->assertSame($value, $error->getValue());
        $this->assertSame($constraint, $error->getConstraint());
    }

    public function testToString(): void
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
