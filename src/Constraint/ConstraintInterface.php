<?php

declare(strict_types=1);

namespace Emonkak\Validation\Constraint;

interface ConstraintInterface
{
    public function getDeclaration(): string;

    public function isSatisfiedBy($value): bool;
}
