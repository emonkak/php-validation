<?php

namespace Emonkak\Validation\Constraint;

class GreaterThan implements ConstraintInterface
{
    /**
     * @var int
     */
    private $criterion;

    /**
     * @param int $criterion
     */
    public function __construct($criterion)
    {
        $this->criterion = $criterion;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return "The number must be greater than {$this->criterion}.";
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy($value)
    {
        return $value > $this->criterion;
    }
}
