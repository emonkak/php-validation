<?php

declare(strict_types=1);

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

    public function __construct(int $minLength, int $maxLength)
    {
        if ($minLength > $maxLength) {
            throw new \InvalidArgumentException('`$minLength` must be less than `$maxLength` or equal.');
        }

        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function getDeclaration(): string
    {
        return "The string length must be between {$this->minLength} and {$this->maxLength}.";
    }

    public function isSatisfiedBy($value): bool
    {
        $length = mb_strlen($value);
        return $this->minLength <= $length && $length <= $this->maxLength;
    }
}
