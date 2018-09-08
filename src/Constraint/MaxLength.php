<?php

namespace Emonkak\Validation\Constraint;

class MaxLength implements ConstraintInterface
{
    /**
     * @var int
     */
    private $maxLength;

    /**
     * @param int $maxLength
     */
    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return "The string length must be less than {$this->maxLength} or equal.";
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy($value)
    {
        return mb_strlen($value) <= $this->maxLength;
    }
}
