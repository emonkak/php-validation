<?php

declare(strict_types=1);

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\Type\TypeInterface;

interface CollectorInterface
{
    /**
     * @param mixed $value
     */
    public function collectTypeError(string $key, $value, TypeInterface $type): void;

    /**
     * @param mixed $value
     */
    public function collectConstraintError(string $key, $value, ConstraintInterface $type): void;
}
