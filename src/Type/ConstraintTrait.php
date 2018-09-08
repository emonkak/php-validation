<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Constraint\ConstraintInterface;

trait ConstraintTrait
{
    /**
     * @param ConstraintInterface[] ...$constraints
     * @return ConstrainedType
     */
    public function withConstraints(ConstraintInterface ...$constraints)
    {
        return new Constrained($this, $constraints);
    }
}
