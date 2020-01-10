<?php

declare(strict_types=1);

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

class NullCollector implements CollectorInterface
{
    public function collectTypeError(string $key, $value, TypeInterface $type): void
    {
    }

    public function collectConstraintError(string $key, $value, ConstraintInterface $constraint): void
    {
    }
}
