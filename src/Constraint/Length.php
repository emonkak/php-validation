<?php

namespace Emonkak\Validation\Constraint;

class Length implements ConstraintInterface
{
    /**
     * @var int
     */
    private $minLength;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @param int $minLength
     * @param int $maxLength
     */
    public function __construct($minLength, $maxLength)
    {
        if ($minLength > $maxLength) {
            throw new \InvalidArgumentException('`$minLength` must be less than `$maxLength` or equal.');
        }

        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return "The string length must be between {$this->minLength} and {$this->maxLength}.";
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy($value)
    {
        $length = mb_strlen($value);
        return $this->minLength <= $length && $length <= $this->maxLength;
    }
}
