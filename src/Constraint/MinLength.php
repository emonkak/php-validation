<?php

namespace Emonkak\Validation\Constraint;

class MinLength implements ConstraintInterface
{
    /**
     * @var int
     */
    private $minLength;

    /**
     * @param int $minLength
     */
    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return "The string length must be greater than {$this->minLength} or equal.";
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy($value)
    {
        return mb_strlen($value) >= $this->minLength;
    }
}
