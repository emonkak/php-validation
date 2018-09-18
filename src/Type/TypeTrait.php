<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Constraint\ConstraintInterface;

trait TypeTrait
{
    /**
     * @return TypeInterface
     */
    public function allowEmpty()
    {
        return new OneOfType([$this, new OneOf(['', null], true)]);
    }

    /**
     * @return TypeInterface
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

    /**
     * @return TypeInterface
     */
    public function union(TypeInterface ...$types)
    {
        return new OneOfType(array_merge([$this], $types));
    }
}
