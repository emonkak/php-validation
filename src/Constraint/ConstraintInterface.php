<?php

declare(strict_types=1);

namespace Emonkak\Validation\Constraint;

interface ConstraintInterface
{
    public function getDeclaration(): string;

    /**
     * @param mixed $value
     */
    public function isSatisfiedBy($value): bool;
}
