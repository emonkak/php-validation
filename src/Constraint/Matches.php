<?php

namespace Emonkak\Validation\Constraint;

class Matches implements ConstraintInterface
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return "The string must match the pattern of `{$this->pattern}`.";
    }

    /**
     * {@inheritDoc}
     */
    public function isSatisfiedBy($value)
    {
        return preg_match($this->pattern, $value) === 1;
    }
}
