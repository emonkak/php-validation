<?php

declare(strict_types=1);

namespace Emonkak\Validation\Constraint;

class Matches implements ConstraintInterface
{
    /**
     * @var string
     */
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function getDeclaration(): string
    {
        return "The string must match the pattern of `{$this->pattern}`.";
    }

    public function isSatisfiedBy($value): bool
    {
        return preg_match($this->pattern, $value) === 1;
    }
}
