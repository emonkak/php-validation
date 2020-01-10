<?php

declare(strict_types=1);

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

    public function getDeclaration(): string
    {
        return "The number must be between {$this->min} and {$this->max}.";
    }

    public function isSatisfiedBy($value): bool
    {
        return $this->min <= $value && $value <= $this->max;
    }
}
