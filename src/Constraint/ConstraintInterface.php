<?php

namespace Emonkak\Validation\Constraint;

interface ConstraintInterface
{
    /**
     * @return string
     */
    public function getDeclaration();

    /**
     * @param mixed $value
     * @return bool
     */
    public function isSatisfiedBy($value);
}
