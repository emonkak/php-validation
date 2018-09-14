<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Constraint\ConstraintInterface;

trait TypeTrait
{
    /**
     * @return Optional
     */
    public function isOptional()
    {
        return new Optional($this);
    }

    /**
     * @param ConstraintInterface[] ...$constraints
     * @return ConstrainedType
     */
    public function withConstraints(ConstraintInterface ...$constraints)
    {
        return new Constrained($this, $constraints);
    }
}
