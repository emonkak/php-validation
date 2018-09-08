<?php

namespace Emonkak\Validation\Constraint;

class Between implements ConstraintInterface
{
    /**
     * @var int|float
     */
    private $min;

    /**
     * @var int|float
     */
    private $max;

    /**
     * @param int|float $min
     * @param int|float $max
     */
    public function __construct($min, $max)
    {
        if ($min > $max) {
            throw new \InvalidArgumentException('`$min` must be less than `$max` or equal.');
        }

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return "The number must be between {$this->min} and {$this->max}.";
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy($value)
    {
        return $this->min <= $value && $value <= $this->max;
    }
}
