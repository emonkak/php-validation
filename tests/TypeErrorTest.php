<?php

declare(strict_types=1);

namespace Emonkak\Validation\Tests;

use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\TypeError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Emonkak\Validation\TypeError
 */
class TypeErrorTest extends TestCase
{
    public function testConstrutor(): void
    {
        $key = 'key';
        $value = 'value';
        $type = $this->createMock(TypeInterface::class);
        $error = new TypeError($key, $value, $type);

        $this->assertSame($key, $error->getKey());
        $this->assertSame($value, $error->getValue());
        $this->assertSame($type, $error->getExpectedType());
    }

    public function testToString(): void
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
