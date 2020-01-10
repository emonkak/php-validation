<?php

declare(strict_types=1);

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

interface CollectorInterface
{
    public function collectTypeError(string $key, $value, TypeInterface $type): void;

    public function collectConstraintError(string $key, $value, ConstraintInterface $type): void;
}
