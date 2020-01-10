<?php

declare(strict_types=1);

namespace Emonkak\Validation;

use Emonkak\Validation\Constraint\ConstraintInterface;

class ConstraintError implements ErrorInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var ConstraintInterface
     */
    private $constraint;

    public function __construct(string $key, $value, ConstraintInterface $constraint)
    {
        $this->key = $key;
        $this->value = $value;
        $this->constraint = $constraint;
    }

    public function __toString(): string
    {
        return sprintf(
            'The property `%s` must satisfy the constraint `%s`, got `%s`.',
            $this->key,
            $this->constraint->getDeclaration(),
            var_export($this->value, true)
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getConstraint(): ConstraintInterface
    {
        return $this->constraint;
    }
}
